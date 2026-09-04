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

        return view('portfolio.index', compact('projects', 'categories'));
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
