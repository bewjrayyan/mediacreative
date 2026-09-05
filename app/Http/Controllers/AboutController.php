<?php

namespace App\Http\Controllers;

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
        $team = TeamMember::active()->ordered()->get();

        $teamPhoto = $team->first(fn ($m) => filled($m->photo));
        $shareImage = $teamPhoto?->photo;

        $this->seo->forPage([
            'title' => 'About',
            'description' => 'Learn more about '.site_name().'.',
            'image' => $shareImage,
            'image_alt' => 'About '.site_name(),
            'url' => route('about'),
        ]);

        return view('pages.about', compact('team'));
    }
}
