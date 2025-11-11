<?php

use App\Models\Article;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Menu;
use App\Models\Category;
use App\Support\ArticleContentHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {
    $articles = Article::query()
        ->with('category')
        ->orderByDesc('publishedAt')
        ->orderByDesc('createdAt')
        ->paginate(6);

    $settings = Setting::query()->first();
    $menuItems = Menu::query()->where('parent_id', null)->get();

    return view('home', [
        'articles' => $articles,
        'settings' => $settings,
        'menuItems' => $menuItems,
    ]);
});

Route::get('/artikel/{slug}', function (string $slug) {
    $cacheKey = 'article:' . $slug;
    
    // Cache only the data, not the view response
    $cachedData = Cache::remember($cacheKey, now()->addHours(24), function () use ($slug) {
        $article = Article::query()->with('category')->where('slug', $slug)->firstOrFail();
        $parsedContent = ArticleContentHelper::extractHeadings($article->content ?? '');
        $contentHtml = $parsedContent['content'];
        $headings = $parsedContent['headings'];

        $settings = Setting::query()->first();
        $menuItems = Menu::query()->where('parent_id', null)->get();
        $metaDescription = $article->excerpt ?: Str::limit(strip_tags((string) ($article->content ?? '')), 160);

        return [
            'article' => $article,
            'contentHtml' => $contentHtml,
            'headings' => $headings,
            'settings' => $settings,
            'menuItems' => $menuItems,
            'metaDescription' => $metaDescription,
        ];
    });

    // Return the view with cached data
    return view('article', $cachedData);
})->name('articles.show');

Route::get('/kategori', function () {
    $categories = Category::query()
        ->withCount('articles')
        ->with(['articles' => function ($query) {
            $query->select(['id', 'title', 'slug', 'excerpt', 'categoryId', 'publishedAt', 'createdAt'])
                ->orderByDesc('publishedAt')
                ->orderByDesc('createdAt');
        }])
        ->orderBy('name')
        ->get();

    $settings = Setting::query()->first();
    $menuItems = Menu::query()->where('parent_id', null)->get();

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
        ->where('categoryId', $category->id)
        ->orderByDesc('publishedAt')
        ->orderByDesc('createdAt')
        ->paginate(8);

    $settings = Setting::query()->first();
    $menuItems = Menu::query()->where('parent_id', null)->get();

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
    $menuItems = Menu::query()->where('parent_id', null)->get();

    return view('page', [
        'page' => $page,
        'settings' => $settings,
        'menuItems' => $menuItems,
    ]);
})->name('pages.show');

Route::get('/sitemap.xml', function () {
    $articles = Article::query()->orderByDesc('updatedAt')->get();
    $pages = Page::query()->where('status', 'published')->orderByDesc('updated_at')->get();
    $baseUrl = rtrim(config('app.url'), '/');

    return response()
        ->view('sitemap', compact('articles', 'pages', 'baseUrl'))
        ->header('Content-Type', 'application/xml');
});

Route::get('/search', function () {
    $query = request('q');
    
    if (!$query) {
        return redirect('/');
    }
    
    $articles = Article::query()
        ->with('category')
        ->where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('content', 'like', "%{$query}%")
              ->orWhere('excerpt', 'like', "%{$query}%");
        })
        ->orderByDesc('publishedAt')
        ->orderByDesc('createdAt')
        ->paginate(10);

    $settings = Setting::query()->first();
    $menuItems = Menu::query()->where('parent_id', null)->get();

    return view('search', [
        'articles' => $articles,
        'query' => $query,
        'settings' => $settings,
        'menuItems' => $menuItems,
    ]);
})->name('search');

// Authentication routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Admin root redirect
Route::get('/adminku', function () {
    return redirect('/adminku/dashboard');
})->middleware('auth');

// Admin routes with regular CRUD (replacing Filament)
Route::middleware(['auth'])->prefix('adminku')->name('adminku.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Article routes
    Route::get('/articles', [App\Http\Controllers\Admin\ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [App\Http\Controllers\Admin\ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [App\Http\Controllers\Admin\ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}', [App\Http\Controllers\Admin\ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/{article}/edit', [App\Http\Controllers\Admin\ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [App\Http\Controllers\Admin\ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [App\Http\Controllers\Admin\ArticleController::class, 'destroy'])->name('articles.destroy');
    
    // Category routes
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Page routes
    Route::get('/pages', [App\Http\Controllers\Admin\PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [App\Http\Controllers\Admin\PageController::class, 'create'])->name('pages.create');
    Route::post('/pages', [App\Http\Controllers\Admin\PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{page}', [App\Http\Controllers\Admin\PageController::class, 'show'])->name('pages.show');
    Route::get('/pages/{page}/edit', [App\Http\Controllers\Admin\PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [App\Http\Controllers\Admin\PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [App\Http\Controllers\Admin\PageController::class, 'destroy'])->name('pages.destroy');
    
    // Menu routes
    Route::get('/menus', [App\Http\Controllers\Admin\MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [App\Http\Controllers\Admin\MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [App\Http\Controllers\Admin\MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/edit', [App\Http\Controllers\Admin\MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [App\Http\Controllers\Admin\MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [App\Http\Controllers\Admin\MenuController::class, 'destroy'])->name('menus.destroy');
    Route::post('/menus/reorder', [App\Http\Controllers\Admin\MenuController::class, 'reorder'])->name('menus.reorder');
});

// Redirect old /admin routes to new /adminku routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::redirect('/dashboard', '/adminku/dashboard', 301);
    Route::redirect('/articles', '/adminku/articles', 301);
});
