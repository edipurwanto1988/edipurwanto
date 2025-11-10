<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 px-4 md:px-10 py-3 relative">
    <div class="flex items-center gap-4">
        <div class="size-5 text-primary">
            <img src="{{ asset('images/icon.png') }}" alt="Icon" class="w-5 h-5 object-contain">
        </div>
        <a href="https://edipurwanto.com" target="_blank" class="text-text-dark text-lg font-bold leading-tight tracking-[-0.015em] hover:text-primary transition-colors">Edi purwanto</a>
    </div>
    <div class="hidden md:flex flex-1 justify-end items-center gap-8">
        <div class="flex items-center gap-9">
            @php
                $primaryMenu = App\Models\Menu::query()->where('parent_id', null)->first();
                $menuItems = App\Models\Menu::query()->where('parent_id', null)->get();
            @endphp
            @forelse ($menuItems as $menuItem)
                <a class="text-text-light hover:text-primary text-sm font-medium leading-normal transition-colors"
                   href="{{ $menuItem->url }}"
                   @if ($menuItem->target === '_blank') target="_blank" @endif>
                    {{ $menuItem->name }}
                </a>
            @empty
                <span class="text-text-light text-sm font-medium leading-normal">No menu items configured</span>
            @endforelse
        </div>
        <a class="text-gray-400 hover:text-primary transition-colors" href="https://www.linkedin.com/in/edipurwantoofficial" target="_blank" rel="noopener noreferrer">
            <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
            </svg>
            <span class="sr-only">LinkedIn</span>
        </a>
    </div>
    <div class="md:hidden">
        <button id="mobile-menu-button" class="text-text-light p-2">
            <span class="material-symbols-outlined text-xl">menu</span>
        </button>
    </div>
</header>

<!-- Mobile Menu Dropdown -->
<div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
    <div class="px-4 py-3 space-y-1 min-w-max">
        @php
            $menuItems = App\Models\Menu::query()->where('parent_id', null)->get();
        @endphp
        @forelse ($menuItems as $menuItem)
            <a class="block text-text-light hover:text-primary text-sm font-medium leading-normal transition-colors px-3 py-2 rounded-md hover:bg-gray-50"
               href="{{ $menuItem->url }}"
               @if ($menuItem->target === '_blank') target="_blank" @endif>
                {{ $menuItem->name }}
            </a>
        @empty
            <span class="block text-text-light text-sm font-medium leading-normal px-3 py-2">No menu items configured</span>
        @endforelse
        <div class="border-t border-gray-200 pt-3 mt-3">
            <a class="flex items-center gap-2 text-text-light hover:text-primary text-sm font-medium leading-normal transition-colors px-3 py-2 rounded-md hover:bg-gray-50"
               href="https://www.linkedin.com/in/edipurwantoofficial" target="_blank" rel="noopener noreferrer">
                <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                </svg>
                LinkedIn
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
        
        // Prevent clicks inside mobile menu from closing it
        mobileMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>