<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;
use App\Services\SeoManager;
use Illuminate\Support\Str;

/**
 * Routed from routes/web.php (services.*). Uses SeoManager for listing/detail SEO.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */
class ServiceController extends Controller
{
    public function __construct(
        private readonly SeoManager $seo,
    ) {}

    public function index()
    {
        $services = Service::active()->ordered()->paginate(9);
        $clients = Client::active()->ordered()->take(12)->get();

        $shareImage = $services->first(fn ($s) => filled($s->image))?->image;

        $this->seo->forPage([
            'title' => 'Services',
            'description' => 'Services offered by '.site_name().'.',
            'image' => $shareImage,
            'image_alt' => 'Services — '.site_name(),
            'url' => route('services.index'),
        ]);

        return view('services.index', compact('services', 'clients'));
    }

    public function show(string $slug)
    {
        $service = Service::active()->where('slug', $slug)->firstOrFail();

        $description = $service->meta_description
            ?: Str::limit(strip_tags((string) $service->description), 160);

        $this->seo->forPage([
            'title' => $service->meta_title ?: $service->title,
            'description' => $description,
            'keywords' => $service->meta_keywords,
            'image' => $service->image,
            'image_alt' => $service->meta_title ?: $service->title,
            'url' => route('services.show', $service->slug),
            'type' => 'product',
        ]);

        return view('services.show', compact('service'));
    }
}
