<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\SeoManager;

/**
 * Routed from routes/web.php (CMS slug pages). Uses Page meta_* + SeoManager.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */
class PageViewController extends Controller
{
    public function __construct(
        private readonly SeoManager $seo,
    ) {}

    public function show(string $slug)
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();

        $this->seo->forPage([
            'title' => $page->meta_title ?: $page->title,
            'description' => $page->meta_description ?: '',
            'keywords' => $page->meta_keywords,
            'image' => setting('seo.og_image'),
            'image_alt' => $page->meta_title ?: $page->title,
            'url' => route('pages.show', $page->slug),
            'type' => 'website',
        ]);

        return view('pages.cms', compact('page'));
    }
}
