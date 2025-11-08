@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
    <h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Edit Article</h1>
    <a href="{{ route('adminku.articles.index') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-gray-600 text-white text-sm font-bold leading-normal tracking-wide hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
        <span class="truncate">Back</span>
    </a>
</header>

<!-- Form -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <form method="POST" action="{{ route('adminku.articles.update', $article) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                        placeholder="Enter article title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $article->slug) }}" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                        placeholder="article-url-slug">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                        placeholder="Brief description of article">{{ old('excerpt', $article->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                    <textarea name="content" id="content" rows="15" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white tinymce-editor"
                        placeholder="Write your article content here...">{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div>
                    <label for="categoryId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                    <select name="categoryId" id="categoryId"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('categoryId', $article->categoryId) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoryId')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="thumbnail_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Image</label>
                    <input type="file" name="thumbnail_image" id="thumbnail_image" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90">
                    @error('thumbnail_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Upload an image (max 2MB).</p>

                    @if ($article->image_url)
                        <div class="mt-2">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Current image:</p>
                            <img src="{{ $article->image_url }}" alt="Current image" class="h-20 w-auto rounded border border-gray-300 dark:border-gray-600">
                        </div>
                    @endif
                </div>


                <div>
                    <label for="publishedAt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Publish Date</label>
                    <input type="datetime-local" name="publishedAt" id="publishedAt" 
                        value="{{ old('publishedAt', $article->publishedAt ? $article->publishedAt->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white">
                    @error('publishedAt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty to save as draft</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors font-medium">
                        Update Article
                    </button>
                    <a href="{{ route('adminku.articles.index') }}" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium text-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
// Article-specific functionality (TinyMCE is handled by layout)
(function() {
    console.log('[Article Edit] Initializing article-specific functionality...');
    
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
            console.log('[Article Edit] TinyMCE editor is available and initialized');
            
            // Focus editor if there's a validation error for content field
            const contentError = document.querySelector('#content + .mt-1.text-sm.text-red-600');
            if (contentError) {
                setTimeout(() => {
                    tinymce.get('content').focus();
                }, 100);
            }
        } else {
            console.warn('[Article Edit] TinyMCE editor not available - may be loading');
        }
    }, 1000);
})();
</script>
@endsection