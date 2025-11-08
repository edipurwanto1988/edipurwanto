@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
<h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Categories Management</h1>
<a href="{{ route('adminku.categories.create') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-wide hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined" style="font-size: 20px;">add_circle</span>
<span class="truncate">Create New</span>
</a>
</header>

<!-- Categories Table -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
<div class="px-6 py-4">
<div class="overflow-x-auto">
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
<thead class="bg-gray-50 dark:bg-gray-800/50 text-xs uppercase">
<tr>
<th class="px-4 py-3 font-medium">Name</th>
<th class="px-4 py-3 font-medium">Slug</th>
<th class="px-4 py-3 font-medium">Articles Count</th>
<th class="px-4 py-3 font-medium">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
@forelse ($categories as $category)
<tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
<td class="px-4 py-4">
<div class="font-medium text-gray-900 dark:text-white">{{ $category->name }}</div>
@if($category->description)
<div class="text-gray-500 text-sm mt-1">{{ Str::limit($category->description, 100) }}</div>
@endif
</td>
<td class="px-4 py-4">
<span class="text-gray-600 dark:text-gray-400">{{ $category->slug }}</span>
</td>
<td class="px-4 py-4">
<span class="inline-flex items-center rounded-full bg-blue-100 text-blue-800 px-2.5 py-0.5 text-xs font-medium">
{{ $category->articles_count }} articles
</span>
</td>
<td class="px-4 py-4">
<div class="flex items-center gap-2">
<a href="{{ route('adminku.categories.edit', $category) }}" class="text-primary hover:text-primary/80">
<span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
</a>
<form method="POST" action="{{ route('adminku.categories.destroy', $category) }}" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
<td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
No categories found.
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</section>

<!-- Pagination -->
@if ($categories->hasPages())
<div class="mt-6">
{{ $categories->links() }}
</div>
@endif
@endsection