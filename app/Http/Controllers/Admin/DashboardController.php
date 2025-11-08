<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::whereNotNull('publishedAt')->count(),
            'draft_articles' => Article::whereNull('publishedAt')->count(),
            'total_categories' => Category::count(),
            'total_pages' => Page::count(),
            'published_pages' => Page::where('status', 'published')->count(),
            'recent_articles' => Article::with('category')
                ->orderByDesc('createdAt')
                ->limit(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}