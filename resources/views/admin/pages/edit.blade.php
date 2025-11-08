@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
<h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Edit Page</h1>
<a href="{{ route('adminku.pages.index') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-gray-600 text-white text-sm font-bold leading-normal tracking-wide hover:bg-gray-700 transition-colors">
<span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
<span class="truncate">Back</span>
</a>
</header>

<!-- Form -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
<form method="POST" action="{{ route('adminku.pages.update', $page) }}">
@csrf
@method('PUT')

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
<!-- Main Content -->
<div class="lg:col-span-2 space-y-6">
<div>
<label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
<input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" required
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="Enter page title">
@error('title')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div>
<label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
<input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" required
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="page-url-slug">
@error('slug')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div>
<label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excerpt</label>
<textarea name="excerpt" id="excerpt" rows="3"
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="Brief description of the page">{{ old('excerpt', $page->excerpt) }}</textarea>
@error('excerpt')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div>
    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
    <textarea name="content" id="content" rows="15" required
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white tinymce-editor"
        placeholder="Write your page content here...">{{ old('content', $page->content) }}</textarea>
    @error('content')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
</div>

<!-- Sidebar -->
<div class="space-y-6">
<div>
<label for="seo_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">SEO Title</label>
<input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title', $page->seo_title) }}"
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="SEO title (optional)">
@error('seo_title')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div>
<label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
<select name="status" id="status"
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white">
<option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>Draft</option>
<option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>Published</option>
</select>
@error('status')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div class="flex gap-3">
<button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors font-medium">
Update Page
</button>
<a href="{{ route('adminku.pages.index') }}" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium text-center">
Cancel
</a>
</div>
</div>
</div>
</form>
</section>

<script>
<script>
// Page-specific functionality (TinyMCE is handled by layout)
(function() {
    console.log('[Page Edit] Initializing page-specific functionality...');
    
    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            // Only auto-generate slug if it's empty or hasn't been manually edited
            if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
                const title = this.value;
                const slug = title.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                    .trim(); // Remove leading/trailing spaces and hyphens
                
                slugInput.value = slug;
                slugInput.dataset.autoGenerated = 'true';
            }
        });
        
        // Mark slug as manually edited when user types in it
        slugInput.addEventListener('input', function() {
            this.dataset.autoGenerated = 'false';
        });
    }
    
    // Wait for TinyMCE to be initialized by layout
    setTimeout(function() {
        if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
            console.log('[Page Edit] TinyMCE editor is available and initialized');
            
            // Focus editor if there's a validation error for content field
            const contentError = document.querySelector('#content + .mt-1.text-sm.text-red-600');
            if (contentError) {
                setTimeout(() => {
                    tinymce.get('content').focus();
                }, 100);
            }
        } else {
            console.warn('[Page Edit] TinyMCE editor not available - may be loading');
        }
    }, 1000);
})();
</script>
@endsection