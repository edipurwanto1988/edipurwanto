<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->orderByDesc('createdAt')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug',
            'categoryId' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'publishedAt' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['id'] = Str::uuid()->toString();
        $validated['authorId'] = Auth::user()->id ?? '1'; // Use authenticated user ID or default
        $validated['createdAt'] = now();
        $validated['updatedAt'] = now();

        // Handle image upload
        if ($request->hasFile('thumbnail_image')) {
            $image = $request->file('thumbnail_image');
            $validated = $this->processImageUpload($validated, $image);
        }

        $article = Article::create($validated);

        // Clear cache for this article
        Cache::forget('article:' . $article->slug);

        return redirect()->route('adminku.articles.index')
            ->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|' . Rule::unique('articles', 'slug')->ignore($article->id),
            'categoryId' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'publishedAt' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['updatedAt'] = now();

        // Handle image upload
        if ($request->hasFile('thumbnail_image')) {
            $image = $request->file('thumbnail_image');
            $validated = $this->processImageUpload($validated, $image);
        }

        $article->update($validated);

        // Clear cache for this article (both old and new slug if changed)
        Cache::forget('article:' . $article->getOriginal('slug'));
        Cache::forget('article:' . $article->slug);

        return redirect()->route('adminku.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Process image upload and generate thumbnail
     */
    private function processImageUpload(array $validated, $image): array
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Store original image
        $path = $image->storeAs('articles/thumbnails', $filename, 'public');
        $validated['image_url'] = $path;
        
        return $validated;
    }

    public function destroy(Article $article)
    {
        // Clear cache for this article before deleting
        Cache::forget('article:' . $article->slug);
        
        $article->delete();

        return redirect()->route('adminku.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}