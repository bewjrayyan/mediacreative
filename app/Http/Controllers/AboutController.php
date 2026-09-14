<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\TeamMember;
use App\Services\SeoManager;

/**
 * Routed from routes/web.php (about). Uses SeoManager for page meta.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */
class AboutController extends Controller
{
    public function __construct(
        private readonly SeoManager $seo,
    ) {}

    public function index()
    {
        $page = Page::active()->where('slug', 'about')->firstOrFail();
        $team = TeamMember::active()->ordered()->get();

        $teamPhoto = $team->first(fn ($m) => filled($m->photo));
        $shareImage = $teamPhoto?->photo;

        $this->seo->forPage([
            'title' => $page->meta_title ?: $page->title,
            'description' => $page->meta_description ?: 'Learn more about '.site_name().'.',
            'keywords' => $page->meta_keywords,
            'image' => $shareImage,
            'image_alt' => $page->title,
            'url' => route('about'),
            'type' => 'website',
        ]);

        return view('pages.about', compact('page', 'team'));
    }
}
