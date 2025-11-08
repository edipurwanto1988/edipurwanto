<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->orderBy('name')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['createdAt'] = now();
        $validated['updatedAt'] = now();

        Category::create($validated);

        return redirect()->route('adminku.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $articles = $category->articles()->orderByDesc('createdAt')->paginate(10);
        return view('admin.categories.show', compact('category', 'articles'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|' . Rule::unique('categories', 'name')->ignore($category->id),
            'slug' => 'required|string|max:255|' . Rule::unique('categories', 'slug')->ignore($category->id),
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['updatedAt'] = now();

        $category->update($validated);

        return redirect()->route('adminku.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Check if category has articles
        if ($category->articles()->count() > 0) {
            return redirect()->route('adminku.categories.index')
                ->with('error', 'Cannot delete category with articles.');
        }

        $category->delete();

        return redirect()->route('adminku.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}