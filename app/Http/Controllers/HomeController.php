<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Services\SeoManager;

/**
 * Routed from routes/web.php (home). Injects SeoManager for public meta tags.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */
class HomeController extends Controller
{
    public function __construct(
        private readonly SeoManager $seo,
    ) {}

    public function index()
    {
        $services = Service::active()->ordered()->take(6)->get();
        $featuredProjects = Project::published()->featured()->take(6)->get();
        $testimonials = Testimonial::active()->ordered()->take(6)->get();
        $clients = Client::active()->ordered()->take(8)->get();

        $shareImage = setting('seo.og_image')
            ?: setting('home.hero_image', setting('hero_image', ''))
            ?: $featuredProjects->first(fn ($p) => filled($p->thumbnail))?->thumbnail;

        $this->seo->forPage([
            'title' => (string) setting('seo.meta_title', site_name()),
            'description' => (string) setting('seo.meta_description', setting('site_description', '')),
            'image' => $shareImage,
            'image_alt' => site_name(),
            'url' => route('home'),
            'type' => 'website',
        ]);

        return view('pages.home', compact('services', 'featuredProjects', 'testimonials', 'clients'));
    }
}
