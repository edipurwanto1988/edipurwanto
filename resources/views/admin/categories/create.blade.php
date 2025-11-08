@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
<h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Create Category</h1>
<a href="{{ route('adminku.categories.index') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-gray-600 text-white text-sm font-bold leading-normal tracking-wide hover:bg-gray-700 transition-colors">
<span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
<span class="truncate">Back</span>
</a>
</header>

<!-- Form -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
<form method="POST" action="{{ route('adminku.categories.store') }}">
@csrf

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
<div class="space-y-6">
<div>
<label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
<input type="text" name="name" id="name" value="{{ old('name') }}" required
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="Enter category name">
@error('name')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div>
<label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
<input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="category-url-slug">
@error('slug')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>
</div>

<div>
<label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
<textarea name="description" id="description" rows="6"
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="Describe this category">{{ old('description') }}</textarea>
@error('description')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>
</div>

<div class="flex gap-3 mt-6">
<button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors font-medium">
Create Category
</button>
<a href="{{ route('adminku.categories.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white px-6 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium">
Cancel
</a>
</div>
</form>
</section>
@endsection