<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::orderBy('location')->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.menu.index', compact('menuItems'));
    }

    public function create()
    {
        $pages = Page::orderBy('title')->get();

        return view('admin.menu.create', compact('pages'));
    }

    public function store(Request $request)
    {
        MenuItem::create($this->validated($request));

        return redirect()->route('admin.menu.index')->with('success', 'Menu item created successfully.');
    }

    public function edit(MenuItem $menuItem)
    {
        $pages = Page::orderBy('title')->get();
        $selectedPageSlug = $this->pageSlugForUrl($menuItem->url, $pages);

        return view('admin.menu.edit', compact('menuItem', 'pages', 'selectedPageSlug'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $menuItem->update($this->validated($request));

        return redirect()->route('admin.menu.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu item deleted successfully.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'page_slug' => ['nullable', 'string', 'exists:pages,slug'],
            'url' => ['nullable', 'string', 'max:2048', 'required_without:page_slug', function ($attribute, $value, $fail) {
                if ($value === null || $value === '') {
                    return;
                }

                if (!str_starts_with($value, '/') && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $fail('The URL must be an internal path beginning with / or a valid external URL.');
                }
            }],
            'location' => ['required', Rule::in(['header', 'footer'])],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (filled($validated['page_slug'] ?? null)) {
            $validated['url'] = $this->pagePath($validated['page_slug']);
        }

        unset($validated['page_slug']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    private function pagePath(string $slug): string
    {
        return $slug === 'about' ? '/about' : '/page/'.$slug;
    }

    private function pageSlugForUrl(string $url, $pages): ?string
    {
        foreach ($pages as $page) {
            if ($url === $this->pagePath($page->slug)) {
                return $page->slug;
            }
        }

        return null;
    }
}
