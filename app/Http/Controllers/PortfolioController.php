<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
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

        // Related projects in the same category
        $related = Project::published()
            ->where('category', $project->category)
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();

        return view('portfolio.show', compact('project', 'related'));
    }
}
