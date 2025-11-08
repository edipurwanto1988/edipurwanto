@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
<h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Articles Management</h1>
<a href="{{ route('adminku.articles.create') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-wide hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined" style="font-size: 20px;">add_circle</span>
<span class="truncate">Create New</span>
</a>
</header>

<!-- Stats -->
<section class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
<div class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50">
<p class="text-gray-600 dark:text-gray-400 text-base font-medium">Total Articles</p>
<p class="text-gray-900 dark:text-white text-3xl font-bold">{{ App\Models\Article::count() }}</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50">
<p class="text-gray-600 dark:text-gray-400 text-base font-medium">Published</p>
<p class="text-gray-900 dark:text-white text-3xl font-bold">{{ App\Models\Article::whereNotNull('publishedAt')->count() }}</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50">
<p class="text-gray-600 dark:text-gray-400 text-base font-medium">Drafts</p>
<p class="text-gray-900 dark:text-white text-3xl font-bold">{{ App\Models\Article::whereNull('publishedAt')->count() }}</p>
</div>
</section>

<!-- Articles Table -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
<div class="px-6 py-4">
<div class="overflow-x-auto">
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
<thead class="bg-gray-50 dark:bg-gray-800/50 text-xs uppercase">
<tr>
<th class="px-4 py-3 font-medium">Title</th>
<th class="px-4 py-3 font-medium">Category</th>
<th class="px-4 py-3 font-medium">Status</th>
<th class="px-4 py-3 font-medium">Created</th>
<th class="px-4 py-3 font-medium">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
@forelse ($articles as $article)
<tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
<td class="px-4 py-4">
<div class="font-medium text-gray-900 dark:text-white">{{ $article->title }}</div>
</td>
<td class="px-4 py-4">
<span class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-medium text-primary">
{{ $article->category->name ?? 'Uncategorized' }}
</span>
</td>
<td class="px-4 py-4">
<span class="inline-flex items-center rounded-full {{ $article->publishedAt ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} px-2.5 py-0.5 text-xs font-medium">
{{ $article->publishedAt ? 'Published' : 'Draft' }}
</span>
</td>
<td class="px-4 py-4 text-gray-500">{{ $article->createdAt->format('M d, Y') }}</td>
<td class="px-4 py-4">
<div class="flex items-center gap-2">
<a href="{{ route('adminku.articles.edit', $article->id) }}" class="text-primary hover:text-primary/80">
<span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
</a>
<form method="POST" action="{{ route('adminku.articles.destroy', $article->id) }}" onsubmit="return confirm('Are you sure?')">
@csrf
@method('DELETE')
<button type="submit" class="text-red-600 hover:text-red-800">
<span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
</button>
</form>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
No articles found.
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</section>
@endsection