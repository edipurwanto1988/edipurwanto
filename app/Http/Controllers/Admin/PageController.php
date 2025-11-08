<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderByDesc('id')->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        Page::create($validated);

        return redirect()->route('adminku.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|' . Rule::unique('pages', 'slug')->ignore($page->id),
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        $page->update($validated);

        return redirect()->route('adminku.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('adminku.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}