@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
    <h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Edit Menu Item</h1>
    <a href="{{ route('adminku.menus.index') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-gray-600 text-white text-sm font-bold leading-normal tracking-wide hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
        <span class="truncate">Back</span>
    </a>
</header>

<!-- Form -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <form method="POST" action="{{ route('adminku.menus.update', $menu) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Main Content -->
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Menu Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                        placeholder="Enter menu name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Custom URL</label>
                    <input type="url" name="url" id="url" value="{{ old('url', $menu->page_id ? '' : $menu->url) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                        placeholder="https://example.com or /custom-path">
                    @error('url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter a custom URL or select a page below</p>
                </div>

                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parent Menu (Optional)</label>
                    <select name="parent_id" id="parent_id"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white">
                        <option value="">No Parent (Top Level)</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" {{ old('parent_id', $menu->parent_id) == $menu->id ? 'selected' : '' }}>{{ $menu->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select a parent menu to create a submenu item</p>
                </div>

                <div>
                    <label for="page_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Or Link to Page</label>
                    <select name="page_id" id="page_id"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white">
                        <option value="">Select a page</option>
                        @foreach($pages as $page)
                            <option value="{{ $page->id }}" {{ old('page_id', $menu->page_id) == $page->id ? 'selected' : '' }}>
                                {{ $page->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('page_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select a page to automatically generate the URL</p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div>
                    <label for="target" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Link Target</label>
                    <select name="target" id="target"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white">
                        <option value="_self" {{ old('target', $menu->target) == '_self' ? 'selected' : '' }}>Same window (_self)</option>
                        <option value="_blank" {{ old('target', $menu->target) == '_blank' ? 'selected' : '' }}>New window (_blank)</option>
                        <option value="_parent" {{ old('target', $menu->target) == '_parent' ? 'selected' : '' }}>Parent frame (_parent)</option>
                        <option value="_top" {{ old('target', $menu->target) == '_top' ? 'selected' : '' }}>Top frame (_top)</option>
                    </select>
                    @error('target')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $menu->order) }}" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                        placeholder="0">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lower numbers appear first</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-primary focus:ring-primary dark:bg-gray-800 dark:border-gray-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Only active menu items will be displayed on the frontend</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors font-medium">
                        Update Menu Item
                    </button>
                    <a href="{{ route('adminku.menus.index') }}" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium text-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('url');
    const pageSelect = document.getElementById('page_id');
    
    // Set initial state based on current selection
    if (pageSelect.value) {
        urlInput.readOnly = true;
        urlInput.classList.add('bg-gray-100', 'dark:bg-gray-700');
    }
    
    // Clear URL when page is selected
    pageSelect.addEventListener('change', function() {
        if (this.value) {
            urlInput.value = '';
            urlInput.readOnly = true;
            urlInput.classList.add('bg-gray-100', 'dark:bg-gray-700');
        } else {
            urlInput.readOnly = false;
            urlInput.classList.remove('bg-gray-100', 'dark:bg-gray-700');
        }
    });
    
    // Clear page selection when URL is entered
    urlInput.addEventListener('input', function() {
        if (this.value) {
            pageSelect.value = '';
        }
    });
});
</script>
@endsection