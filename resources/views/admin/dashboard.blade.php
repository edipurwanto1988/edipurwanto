@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
<h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Dashboard</h1>
<a href="{{ route('adminku.articles.create') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-wide hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined" style="font-size: 20px;">add_circle</span>
<span class="truncate">Create New Article</span>
</a>
</header>

<!-- Stats -->
<section class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
<div class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50">
<p class="text-gray-600 dark:text-gray-400 text-base font-medium">Total Articles</p>
<p class="text-gray-900 dark:text-white text-3xl font-bold">{{ $stats['total_articles'] }}</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50">
<p class="text-gray-600 dark:text-gray-400 text-base font-medium">Published Articles</p>
<p class="text-gray-900 dark:text-white text-3xl font-bold">{{ $stats['published_articles'] }}</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50">
<p class="text-gray-600 dark:text-gray-400 text-base font-medium">Draft Articles</p>
<p class="text-gray-900 dark:text-white text-3xl font-bold">{{ $stats['draft_articles'] }}</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50">
<p class="text-gray-600 dark:text-gray-400 text-base font-medium">Total Categories</p>
<p class="text-gray-900 dark:text-white text-3xl font-bold">{{ $stats['total_categories'] }}</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50">
<p class="text-gray-600 dark:text-gray-400 text-base font-medium">Total Pages</p>
<p class="text-gray-900 dark:text-white text-3xl font-bold">{{ $stats['total_pages'] }}</p>
</div>
</section>

<!-- Charts -->
<section class="mb-8">
<div class="flex min-w-72 flex-1 flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-800 p-6 bg-white dark:bg-gray-900/50">
<p class="text-gray-900 dark:text-white text-lg font-bold">Recent Activity</p>
<div class="flex items-baseline gap-4">
<p class="text-gray-900 dark:text-white text-4xl font-bold truncate">{{ $stats['recent_articles']->count() }}</p>
<div class="flex gap-1 items-center">
<p class="text-gray-500 dark:text-gray-400 text-sm">Last 7 Days</p>
<p class="text-green-600 dark:text-green-500 text-sm font-medium">+{{ rand(5, 25) }}%</p>
</div>
</div>
<div class="grid min-h-[180px] grid-flow-col gap-6 grid-rows-[1fr_auto] items-end justify-items-center">
<div class="bg-primary/20 dark:bg-primary/30 w-full rounded-t-md" style="height: 70%;"></div>
<p class="text-gray-500 dark:text-gray-400 text-xs font-bold">Mon</p>
<div class="bg-primary/20 dark:bg-primary/30 w-full rounded-t-md" style="height: 30%;"></div>
<p class="text-gray-500 dark:text-gray-400 text-xs font-bold">Tue</p>
<div class="bg-primary/20 dark:bg-primary/30 w-full rounded-t-md" style="height: 40%;"></div>
<p class="text-gray-500 dark:text-gray-400 text-xs font-bold">Wed</p>
<div class="bg-primary/20 dark:bg-primary/30 w-full rounded-t-md" style="height: 40%;"></div>
<p class="text-gray-500 dark:text-gray-400 text-xs font-bold">Thu</p>
<div class="bg-primary/20 dark:bg-primary/30 w-full rounded-t-md" style="height: 60%;"></div>
<p class="text-gray-500 dark:text-gray-400 text-xs font-bold">Fri</p>
<div class="bg-primary w-full rounded-t-md" style="height: 85%;"></div>
<p class="text-gray-900 dark:text-white text-xs font-bold">Sat</p>
<div class="bg-primary/20 dark:bg-primary/30 w-full rounded-t-md" style="height: 20%;"></div>
<p class="text-gray-500 dark:text-gray-400 text-xs font-bold">Sun</p>
</div>
</div>
</section>

<!-- SectionHeader for Quick Actions -->
<h2 class="text-gray-900 dark:text-white text-xl font-bold mb-4">Quick Actions</h2>
<section class="grid grid-cols-1 gap-6 md:grid-cols-2">
<a href="{{ route('adminku.articles.index') }}" class="flex items-start gap-4 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50 hover:border-primary dark:hover:border-primary transition-colors group">
<div class="bg-primary/10 dark:bg-primary/20 text-primary p-3 rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined">edit_document</span>
</div>
<div class="flex flex-col">
<h3 class="text-gray-900 dark:text-white font-bold mb-1 group-hover:text-primary">Manage Articles</h3>
<p class="text-gray-600 dark:text-gray-400 text-sm">Create, edit, and publish blog articles.</p>
</div>
</a>
<a href="{{ route('adminku.categories.index') }}" class="flex items-start gap-4 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50 hover:border-primary dark:hover:border-primary transition-colors group">
<div class="bg-primary/10 dark:bg-primary/20 text-primary p-3 rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined">category</span>
</div>
<div class="flex flex-col">
<h3 class="text-gray-900 dark:text-white font-bold mb-1 group-hover:text-primary">Manage Categories</h3>
<p class="text-gray-600 dark:text-gray-400 text-sm">Organize articles by categories.</p>
</div>
</a>
<a href="{{ route('adminku.pages.index') }}" class="flex items-start gap-4 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50 hover:border-primary dark:hover:border-primary transition-colors group">
<div class="bg-primary/10 dark:bg-primary/20 text-primary p-3 rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined">article</span>
</div>
<div class="flex flex-col">
<h3 class="text-gray-900 dark:text-white font-bold mb-1 group-hover:text-primary">Manage Pages</h3>
<p class="text-gray-600 dark:text-gray-400 text-sm">Create and manage static pages.</p>
</div>
</a>
</section>
@endsection