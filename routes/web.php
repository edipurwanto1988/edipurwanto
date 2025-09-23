<?php

use App\Models\Article;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Menu;
use App\Models\Category;
use App\Support\ArticleContentHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    $articles = Article::query()
        ->with('category')
        ->orderByDesc('published_at')
        ->orderByDesc('created_at')
        ->paginate(5);

    $settings = Setting::query()->first();
    $menuItems = optional(Menu::query()->where('slug', 'primary')->first())->resolved_items;

    return view('home', [
        'articles' => $articles,
        'settings' => $settings,
        'menuItems' => $menuItems,
    ]);
});

Route::get('/artikel/{slug}', function (string $slug) {
    $article = Article::query()->with('category')->where('slug', $slug)->firstOrFail();
    $parsedContent = ArticleContentHelper::extractHeadings($article->content ?? '');
    $contentHtml = $parsedContent['content'];
    $headings = $parsedContent['headings'];

    $settings = Setting::query()->first();
    $menuItems = optional(Menu::query()->where('slug', 'primary')->first())->resolved_items;
    $metaDescription = $article->excerpt ?: Str::limit(strip_tags((string) ($article->content ?? '')), 160);

    return view('article', [
        'article' => $article,
        'contentHtml' => $contentHtml,
        'headings' => $headings,
        'settings' => $settings,
        'menuItems' => $menuItems,
        'metaDescription' => $metaDescription,
    ]);
})->name('articles.show');

Route::get('/kategori', function () {
    $categories = Category::query()
        ->withCount('articles')
        ->with(['articles' => function ($query) {
            $query->select(['id', 'title', 'slug', 'excerpt', 'category_id', 'published_at', 'created_at'])
                ->orderByDesc('published_at')
                ->orderByDesc('created_at');
        }])
        ->orderBy('name')
        ->get();

    $settings = Setting::query()->first();
    $menuItems = optional(Menu::query()->where('slug', 'primary')->first())->resolved_items;

    return view('categories', [
        'categories' => $categories,
        'settings' => $settings,
        'menuItems' => $menuItems,
    ]);
})->name('categories.index');

Route::get('/kategori/{slug}', function (string $slug) {
    $category = Category::query()
        ->where('slug', $slug)
        ->firstOrFail();

    $articles = Article::query()
        ->where('category_id', $category->id)
        ->orderByDesc('published_at')
        ->orderByDesc('created_at')
        ->paginate(8);

    $settings = Setting::query()->first();
    $menuItems = optional(Menu::query()->where('slug', 'primary')->first())->resolved_items;

    return view('category', [
        'category' => $category,
        'articles' => $articles,
        'settings' => $settings,
        'menuItems' => $menuItems,
    ]);
})->name('categories.show');

Route::get('/pages/{slug}', function (string $slug) {
    $page = Page::query()
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    $settings = Setting::query()->first();
    $menuItems = optional(Menu::query()->where('slug', 'primary')->first())->resolved_items;

    return view('page', [
        'page' => $page,
        'settings' => $settings,
        'menuItems' => $menuItems,
    ]);
})->name('pages.show');

Route::get('/sitemap.xml', function () {
    $articles = Article::query()->orderByDesc('updated_at')->get();
    $pages = Page::query()->where('status', 'published')->orderByDesc('updated_at')->get();
    $baseUrl = rtrim(config('app.url'), '/');

    return response()
        ->view('sitemap', compact('articles', 'pages', 'baseUrl'))
        ->header('Content-Type', 'application/xml');
});
