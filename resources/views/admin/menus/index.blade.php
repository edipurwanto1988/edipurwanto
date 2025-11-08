@extends('layouts.admin.app')

@section('content')
<!-- PageHeading -->
<header class="flex flex-wrap items-center justify-between gap-4 mb-8">
    <h1 class="text-gray-900 dark:text-white text-3xl font-bold leading-tight">Menu Management</h1>
    <a href="{{ route('adminku.menus.create') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-wide hover:bg-primary/90 transition-colors">
        <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
        <span class="truncate">Add Menu</span>
    </a>
</header>

<!-- Menu List -->
<section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    @if($menus->count() > 0)
        <div class="space-y-4" id="menu-list">
            @foreach($menus as $menu)
                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors menu-item" data-menu-id="{{ $menu->id }}">
                    <div class="flex items-center gap-4">
                        <div class="cursor-move text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <span class="material-symbols-outlined" style="font-size: 20px;">drag_indicator</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">{{ $menu->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($menu->page_id)
                                    Page: {{ $menu->page->title }}
                                @else
                                    URL: {{ $menu->url }}
                                @endif
                                @if($menu->target !== '_blank')
                                    <span class="ml-2 text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $menu->target }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs rounded-full {{ $menu->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300' }}">
                            {{ $menu->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <a href="{{ route('adminku.menus.edit', $menu) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                            <span class="material-symbols-outlined" style="font-size: 20px;">edit</span>
                        </a>
                        <form method="POST" action="{{ route('adminku.menus.destroy', $menu) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this menu item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                <span class="material-symbols-outlined" style="font-size: 20px;">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600" style="font-size: 64px;">menu</span>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No menu items found</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Get started by creating your first menu item.</p>
            <a href="{{ route('adminku.menus.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined mr-2" style="font-size: 20px;">add</span>
                Add Menu Item
            </a>
        </div>
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuList = document.getElementById('menu-list');
    if (menuList) {
        new Sortable(menuList, {
            animation: 150,
            handle: '.cursor-move',
            onEnd: function(evt) {
                const menuIds = Array.from(menuList.querySelectorAll('.menu-item')).map(item => item.dataset.menuId);
                
                fetch('{{ route("adminku.menus.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        menus: menuIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Menu order updated successfully');
                    }
                })
                .catch(error => {
                    console.error('Error updating menu order:', error);
                });
            }
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
@endsection