<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Models\Project;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use ReflectionObject;

/**
 * Callers: ConfigureSeoDefaults middleware; public controllers (Home, Portfolio, Blog, Services, About, Contact, PageView).
 * API: applyDefaults(), forPage(array). Always resolves an OG/Twitter share image.
 * User: make sure all have OG for good sharing image
 */
final class SeoManager
{
    private const OG_WIDTH = 1200;

    private const OG_HEIGHT = 630;

    /**
     * Apply site-wide SEO defaults from PageSetting (admin Settings → SEO).
     */
    public function applyDefaults(): void
    {
        $siteName = $this->plain(site_name());
        $title = $this->plain((string) setting('seo.meta_title', setting('meta_title', $siteName)));
        $description = $this->plain((string) setting('seo.meta_description', setting('meta_description', setting('site_description', ''))));
        $keywords = $this->keywordList((string) setting('seo.keywords', setting('keywords', '')));

        SEOTools::setTitle($title !== '' ? $title : $siteName);
        SEOTools::metatags()->setTitleDefault($siteName);
        SEOTools::metatags()->setTitleSeparator(' · ');

        if ($description !== '') {
            SEOTools::setDescription($description);
        }

        if ($keywords !== []) {
            SEOTools::metatags()->setKeywords($keywords);
        }

        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->setSiteName($siteName);
        SEOTools::twitter()->setType('summary_large_image');

        SEOTools::jsonLd()->setType('WebSite');
        SEOTools::jsonLd()->setTitle($title !== '' ? $title : $siteName);
        if ($description !== '') {
            SEOTools::jsonLd()->setDescription($description);
        }
        SEOTools::jsonLd()->setUrl(url('/'));

        $this->applyShareImage($this->resolveShareImage(), $siteName);
    }

    /**
     * Override SEO for a specific public page.
     *
     * @param  array{title?:string,description?:string,image?:string|null,type?:string,url?:string|null,keywords?:array<int,string>|string|null,image_alt?:string|null}  $data
     */
    public function forPage(array $data): void
    {
        $siteName = $this->plain(site_name());
        $title = $this->plain((string) ($data['title'] ?? ''));
        $description = $this->plain((string) ($data['description'] ?? ''));
        $type = $this->plain((string) ($data['type'] ?? 'website')) ?: 'website';
        $url = $this->safeUrl($data['url'] ?? url()->current()) ?? url()->current();
        $imageAlt = $this->plain((string) ($data['image_alt'] ?? ($title !== '' ? $title : $siteName)));

        if ($title !== '') {
            SEOTools::setTitle($title);
            SEOTools::jsonLd()->setTitle($title);
        }

        if ($description !== '') {
            SEOTools::setDescription($description);
            SEOTools::jsonLd()->setDescription($description);
        }

        if (isset($data['keywords'])) {
            $keywords = is_array($data['keywords'])
                ? array_values(array_filter(array_map(fn ($k) => $this->plain((string) $k), $data['keywords'])))
                : $this->keywordList((string) $data['keywords']);
            if ($keywords !== []) {
                SEOTools::metatags()->setKeywords($keywords);
            }
        }

        SEOTools::setCanonical($url);
        SEOTools::opengraph()->setUrl($url);
        SEOTools::opengraph()->setType($type);
        SEOTools::opengraph()->setSiteName($siteName);
        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::jsonLd()->setType($type === 'article' ? 'Article' : ($type === 'product' ? 'Product' : 'WebPage'));
        SEOTools::jsonLd()->setUrl($url);

        $image = $this->resolveShareImage($data['image'] ?? null);
        $this->applyShareImage($image, $imageAlt);
    }

    /**
     * Resolve absolute share image URL. Never returns null when default asset exists.
     */
    public function resolveShareImage(mixed $preferred = null): ?string
    {
        $candidates = [
            $preferred,
            setting('seo.og_image', setting('og_image', '')),
            setting('home.hero_image', setting('hero_image', '')),
            setting('general.logo', setting('logo', '')),
            $this->firstProjectThumbnail(),
            $this->firstPostCover(),
            'images/og-default.jpg',
        ];

        foreach ($candidates as $candidate) {
            $url = $this->toAbsoluteImageUrl($candidate);
            if ($url !== null) {
                return $url;
            }
        }

        return null;
    }

    private function applyShareImage(?string $imageUrl, string $alt): void
    {
        if ($imageUrl === null) {
            return;
        }

        $this->resetOpenGraphImages();

        SEOTools::opengraph()->addImage($imageUrl, [
            'width' => self::OG_WIDTH,
            'height' => self::OG_HEIGHT,
            'alt' => $alt !== '' ? $alt : site_name(),
            'type' => $this->guessMime($imageUrl),
        ]);

        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::twitter()->setImage($imageUrl);
        SEOTools::jsonLd()->setImages([$imageUrl]);
    }

    private function resetOpenGraphImages(): void
    {
        $og = SEOTools::opengraph();
        $ref = new ReflectionObject($og);
        if ($ref->hasProperty('images')) {
            $prop = $ref->getProperty('images');
            $prop->setAccessible(true);
            $prop->setValue($og, []);
        }
    }

    private function toAbsoluteImageUrl(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);
        if ($value === '') {
            return null;
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $this->safeUrl($value);
        }

        // Already a public web path
        if (Str::startsWith($value, ['/storage/', 'storage/', '/images/', 'images/', '/adminator/'])) {
            $path = '/'.ltrim($value, '/');

            return $this->safeUrl(url($path));
        }

        // Stored on public disk
        $storageCandidate = public_path('storage/'.ltrim($value, '/'));
        if (is_file($storageCandidate)) {
            return $this->safeUrl(asset('storage/'.ltrim($value, '/')));
        }

        // Public asset (e.g. images/og-default.jpg)
        $publicCandidate = public_path(ltrim($value, '/'));
        if (is_file($publicCandidate)) {
            return $this->safeUrl(asset(ltrim($value, '/')));
        }

        // Optimistic storage URL (file may exist via symlink in production)
        if (preg_match('/\.(jpe?g|png|gif|webp|avif)$/i', $value) === 1) {
            return $this->safeUrl(asset('storage/'.ltrim($value, '/')));
        }

        return null;
    }

    private function firstProjectThumbnail(): ?string
    {
        try {
            if (! Schema::hasTable('projects')) {
                return null;
            }

            return Project::query()
                ->published()
                ->whereNotNull('thumbnail')
                ->where('thumbnail', '!=', '')
                ->ordered()
                ->value('thumbnail');
        } catch (\Throwable) {
            return null;
        }
    }

    private function firstPostCover(): ?string
    {
        try {
            if (! Schema::hasTable('posts')) {
                return null;
            }

            return Post::query()
                ->published()
                ->whereNotNull('cover_image')
                ->where('cover_image', '!=', '')
                ->latest('published_at')
                ->value('cover_image');
        } catch (\Throwable) {
            return null;
        }
    }

    private function guessMime(string $url): string
    {
        $path = strtolower((string) parse_url($url, PHP_URL_PATH));

        return match (true) {
            Str::endsWith($path, '.png') => 'image/png',
            Str::endsWith($path, '.webp') => 'image/webp',
            Str::endsWith($path, '.gif') => 'image/gif',
            Str::endsWith($path, '.avif') => 'image/avif',
            default => 'image/jpeg',
        };
    }

    private function plain(string $value): string
    {
        return trim(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    /**
     * @return list<string>
     */
    private function keywordList(string $raw): array
    {
        if ($raw === '') {
            return [];
        }

        return array_values(array_filter(array_map(
            fn (string $part) => $this->plain($part),
            preg_split('/\s*,\s*/', $raw) ?: []
        )));
    }

    private function safeUrl(mixed $url): ?string
    {
        if (! is_string($url)) {
            return null;
        }

        $url = trim($url);
        if ($url === '') {
            return null;
        }

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        if (! in_array($scheme, ['http', 'https'], true)) {
            return null;
        }

        return $url;
    }
}
