<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\SeoManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Routed from routes/web.php (portfolio.*). Uses SeoManager for listing/detail SEO.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */
class PortfolioController extends Controller
{
    public function __construct(
        private readonly SeoManager $seo,
    ) {}

    public function index(Request $request)
    {
        $query = Project::published();

        $categories = Project::CATEGORIES;

        if ($request->filled('category') && in_array($request->category, $categories)) {
            $query->where('category', $request->category);
        }

        $projects = $query->ordered()->paginate(9)->withQueryString();

        $totalProjects = Project::published()->count();
        $categoryCounts = Project::published()
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        $previewProjects = Project::published()
            ->whereNotNull('thumbnail')
            ->where('thumbnail', '!=', '')
            ->ordered()
            ->take(3)
            ->get();

        if ($previewProjects->count() < 3) {
            $previewProjects = $previewProjects
                ->concat(
                    Project::published()
                        ->ordered()
                        ->take(3)
                        ->get()
                )
                ->unique('id')
                ->take(3)
                ->values();
        }

        $shareImage = $previewProjects->first(fn ($p) => filled($p->thumbnail))?->thumbnail
            ?: $projects->first(fn ($p) => filled($p->thumbnail))?->thumbnail;

        $this->seo->forPage([
            'title' => 'Portfolio',
            'description' => 'Selected projects and case studies from '.site_name().'.',
            'image' => $shareImage,
            'image_alt' => 'Portfolio — '.site_name(),
            'url' => route('portfolio.index'),
        ]);

        return view('portfolio.index', compact(
            'projects',
            'categories',
            'totalProjects',
            'categoryCounts',
            'previewProjects'
        ));
    }

    public function show(string $slug)
    {
        $project = Project::published()->where('slug', $slug)->firstOrFail();

        $related = Project::published()
            ->where('category', $project->category)
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();

        $description = $project->meta_description
            ?: Str::limit(strip_tags((string) $project->description), 160);

        $this->seo->forPage([
            'title' => $project->meta_title ?: $project->title,
            'description' => $description,
            'keywords' => $project->meta_keywords,
            'image' => $project->thumbnail,
            'image_alt' => $project->meta_title ?: $project->title,
            'url' => route('portfolio.show', $project->slug),
            'type' => 'article',
        ]);

        return view('portfolio.show', compact('project', 'related'));
    }
}
