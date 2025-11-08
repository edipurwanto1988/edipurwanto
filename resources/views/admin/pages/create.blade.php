@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
<h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Create Page</h1>
<a href="{{ route('adminku.pages.index') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-gray-600 text-white text-sm font-bold leading-normal tracking-wide hover:bg-gray-700 transition-colors">
<span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
<span class="truncate">Back</span>
</a>
</header>

<!-- Form -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
<form method="POST" action="{{ route('adminku.pages.store') }}">
@csrf

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
<!-- Main Content -->
<div class="lg:col-span-2 space-y-6">
<div>
<label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
<input type="text" name="title" id="title" value="{{ old('title') }}" required
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="Enter page title">
@error('title')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div>
<label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
<input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
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
placeholder="Brief description of the page">{{ old('excerpt') }}</textarea>
@error('excerpt')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div>
<label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
<textarea name="content" id="content" rows="15" required
class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
placeholder="Write your page content here...">{{ old('content') }}</textarea>
@error('content')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>
</div>

<!-- Sidebar -->
<div class="space-y-6">
<div>
<label for="seo_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">SEO Title</label>
<input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title') }}"
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
<option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
<option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
</select>
@error('status')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

<div class="flex gap-3">
<button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors font-medium">
Create Page
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
// TinyMCE initialization for page creation
document.addEventListener('DOMContentLoaded', function() {
    console.log('[TinyMCE] DOM loaded, initializing page creation editor...');
    
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
    
    // Initialize TinyMCE with enhanced configuration for pages
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
            ],
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | codesample | fullscreen | help',
            menubar: 'file edit view insert format tools table help',
            codesample_languages: [
                {text: 'HTML/XML', value: 'markup'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'CSS', value: 'css'},
                {text: 'PHP', value: 'php'},
                {text: 'Python', value: 'python'},
                {text: 'Java', value: 'java'},
                {text: 'C', value: 'c'},
                {text: 'C++', value: 'cpp'},
                {text: 'C#', value: 'csharp'},
                {text: 'SQL', value: 'sql'},
                {text: 'Bash', value: 'bash'},
                {text: 'JSON', value: 'json'},
                {text: 'YAML', value: 'yaml'},
                {text: 'Markdown', value: 'markdown'}
            ],
            content_style: `
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                    font-size: 14px;
                    line-height: 1.6;
                    color: #333;
                    padding: 1rem;
                }
                /* Enhanced code sample styling */
                pre {
                    background: #2d2d2d;
                    color: #f8f8f2;
                    border-radius: 8px;
                    padding: 1rem;
                    margin: 1rem 0;
                    overflow-x: auto;
                    border: 1px solid #444;
                    font-family: 'Fira Code', 'Monaco', 'Consolas', 'Ubuntu Mono', monospace;
                    font-size: 14px;
                    line-height: 1.5;
                }
                code {
                    background: #f5f5f5;
                    padding: 0.2rem 0.4rem;
                    border-radius: 3px;
                    font-family: 'Courier New', Courier, monospace;
                    font-size: 13px;
                }
                pre code {
                    background: transparent;
                    color: inherit;
                    padding: 0;
                    border-radius: 0;
                    font-family: inherit;
                    font-size: inherit;
                }
            `,
            setup: function(editor) {
                console.log('[TinyMCE] Page creation editor initialized:', editor.id);
                
                // Add custom CSS for better code sample integration
                editor.on('init', function() {
                    console.log('[TinyMCE] Page creation editor ready');
                    
                    // Add Prism.js compatibility classes
                    const contentDoc = editor.getDoc();
                    const style = contentDoc.createElement('style');
                    style.textContent = `
                        /* Enhanced Prism.js compatibility for TinyMCE code samples */
                        .mce-content-body pre[class*="language-"] {
                            background: #2d2d2d !important;
                            color: #f8f8f2 !important;
                            border-radius: 8px !important;
                            padding: 1rem !important;
                            margin: 1rem 0 !important;
                            overflow-x: auto !important;
                            border: 1px solid #444 !important;
                            font-family: 'Fira Code', 'Monaco', 'Consolas', 'Ubuntu Mono', monospace !important;
                            font-size: 14px !important;
                            line-height: 1.5 !important;
                        }
                        .mce-content-body code[class*="language-"] {
                            background: transparent !important;
                            color: inherit !important;
                            padding: 0 !important;
                            border-radius: 0 !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                        }
                    `;
                    contentDoc.head.appendChild(style);
                });
                
                // Handle content changes
                editor.on('change', function() {
                    const content = editor.getContent();
                    const textarea = document.getElementById('content');
                    if (textarea) {
                        textarea.value = content;
                    }
                });
                
                // Sync content on form submission
                const form = editor.targetElm.form;
                if (form) {
                    form.addEventListener('submit', function() {
                        editor.save();
                        console.log('[TinyMCE] Content synced on form submission');
                    });
                }
                
                // Add code sample dialog enhancement
                editor.ui.registry.addButton('enhancedcodesample', {
                    text: 'Code Sample',
                    tooltip: 'Insert code sample with syntax highlighting',
                    onAction: function() {
                        editor.execCommand('codesample');
                    }
                });
                
                // Focus editor if there's a validation error for content field
                const contentError = document.querySelector('#content + .mt-1.text-sm.text-red-600');
                if (contentError) {
                    setTimeout(() => {
                        editor.focus();
                    }, 100);
                }
            }
        });
        
        console.log('[TinyMCE] Page creation editor initialization started');
    } else {
        console.error('[TinyMCE] TinyMCE not loaded for page creation');
    }
});
</script>
@endsection