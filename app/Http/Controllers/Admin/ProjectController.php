<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('client', 'like', "%{$search}%");
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $projects = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $categories = Project::CATEGORIES;

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function create()
    {
        $categories = Project::CATEGORIES;
        $services = Service::active()->ordered()->get();

        return view('admin.projects.create', compact('categories', 'services'));
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['technologies'] = array_values(array_filter($request->input('technologies', [])));

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $paths = [];
            foreach ($request->file('gallery_images') as $image) {
                $paths[] = $image->store('projects/gallery', 'public');
            }
            $data['gallery_images'] = $paths;
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $categories = Project::CATEGORIES;
        $services = Service::active()->ordered()->get();

        return view('admin.projects.edit', compact('project', 'categories', 'services'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['technologies'] = array_values(array_filter($request->input('technologies', [])));

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $existing = $project->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $image) {
                $existing[] = $image->store('projects/gallery', 'public');
            }
            $data['gallery_images'] = $existing;
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => ! $project->is_featured]);

        return back()->with('success', 'Project featured status updated.');
    }
}
