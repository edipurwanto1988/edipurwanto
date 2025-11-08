@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
<div class="flex items-center gap-4">
<a href="{{ route('admin.articles.index') }}" class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-primary">
<span class="material-symbols-outlined">arrow_back</span>
Back to Articles
</a>
<h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Article Details</h1>
</div>
<div class="flex gap-2">
<a href="{{ route('filament.admin.resources.articles.edit', $article->id) }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-wide hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined" style="font-size: 20px;">edit</span>
<span class="truncate">Edit</span>
</a>
</div>
</header>

<!-- Article Content -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
<div class="p-6">
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
<div class="lg:col-span-2">
<h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $article->title }}</h2>
<div class="prose prose-lg max-w-none prose-headings:font-semibold prose-a:text-primary hover:prose-a:underline">
{!! $article->content !!}
</div>
</div>
<div class="space-y-4">
@if ($article->thumbnail_url)
<div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-800">
<img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
</div>
@endif
<div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
<h3 class="font-semibold text-gray-900 dark:text-white mb-2">Article Information</h3>
<div class="space-y-2 text-sm">
<div class="flex justify-between">
<span class="text-gray-600 dark:text-gray-400">Status:</span>
<span class="inline-flex items-center rounded-full {{ $article->publishedAt ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} px-2.5 py-0.5 text-xs font-medium">
{{ $article->publishedAt ? 'Published' : 'Draft' }}
</span>
</div>
@if ($article->category)
<div class="flex justify-between">
<span class="text-gray-600 dark:text-gray-400">Category:</span>
<span class="text-primary">{{ $article->category->name }}</span>
</div>
@endif
<div class="flex justify-between">
<span class="text-gray-600 dark:text-gray-400">Created:</span>
<span class="text-gray-900 dark:text-white">{{ $article->createdAt->format('M d, Y') }}</span>
</div>
@if ($article->publishedAt)
<div class="flex justify-between">
<span class="text-gray-600 dark:text-gray-400">Published:</span>
<span class="text-gray-900 dark:text-white">{{ $article->publishedAt->format('M d, Y') }}</span>
</div>
@endif
<div class="flex justify-between">
<span class="text-gray-600 dark:text-gray-400">Reading Time:</span>
<span class="text-gray-900 dark:text-white">{{ ceil(str_word_count(strip_tags($article->content ?? '')) / 200) }} min</span>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection