<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 px-4 md:px-10 py-3 relative">
    <div class="flex items-center gap-4">
        <div class="size-5 text-primary">
            <img src="{{ asset('images/icon.png') }}" alt="Icon" class="w-5 h-5 object-contain">
        </div>
        <a href="https://edipurwanto.com" target="_self" class="text-text-dark text-lg font-bold leading-tight tracking-[-0.015em] hover:text-primary transition-colors">Edi purwanto</a>
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
<div id="mobile-menu" class="hidden relative md:absolute md:top-full md:left-0 md:right-0 bg-white border-t border-gray-200 shadow-lg z-50 md:z-50">
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
    console.log('[Mobile Menu] DOM loaded, checking elements...');
    
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    console.log('[Mobile Menu] Button found:', mobileMenuButton !== null);
    console.log('[Mobile Menu] Menu found:', mobileMenu !== null);
    
    if (mobileMenuButton && mobileMenu) {
        console.log('[Mobile Menu] Setting up event listeners...');
        
        // Check if event listeners already exist
        console.log('[Mobile Menu] Existing click listeners on button:', mobileMenuButton.onclick);
        
        // Remove existing click listener to prevent duplicates
        mobileMenuButton.removeEventListener('click', mobileMenuButton._clickHandler);
        
        // Store the handler reference for potential removal
        mobileMenuButton._clickHandler = function(e) {
            console.log('[Mobile Menu] Button clicked, toggling menu...');
            console.log('[Mobile Menu] Current classes:', mobileMenu.className);
            console.log('[Mobile Menu] Current computed style:', window.getComputedStyle(mobileMenu).display);
            e.stopPropagation();
            
            // Use a more robust toggle approach
            const isHidden = mobileMenu.classList.contains('hidden');
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                console.log('[Mobile Menu] Menu shown');
            } else {
                mobileMenu.classList.add('hidden');
                console.log('[Mobile Menu] Menu hidden');
            }
            
            console.log('[Mobile Menu] Menu hidden class after toggle:', mobileMenu.classList.contains('hidden'));
            console.log('[Mobile Menu] New classes:', mobileMenu.className);
            console.log('[Mobile Menu] New computed style:', window.getComputedStyle(mobileMenu).display);
        };
        
        // Add the click listener
        mobileMenuButton.addEventListener('click', mobileMenuButton._clickHandler);
        
        // Remove existing document click listener to prevent duplicates
        document.removeEventListener('click', document._mobileMenuOutsideClick);
        
        // Close mobile menu when clicking outside
        document._mobileMenuOutsideClick = function(event) {
            console.log('[Mobile Menu] Document click event triggered');
            console.log('[Mobile Menu] Click target:', event.target);
            console.log('[Mobile Menu] Is button target:', mobileMenuButton.contains(event.target));
            console.log('[Mobile Menu] Is menu target:', mobileMenu.contains(event.target));
            
            // Only close menu if it's currently visible
            const isMenuVisible = !mobileMenu.classList.contains('hidden');
            
            if (isMenuVisible && !mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                console.log('[Mobile Menu] Clicked outside, closing menu...');
                mobileMenu.classList.add('hidden');
            }
        };
        
        // Add the document click listener
        document.addEventListener('click', document._mobileMenuOutsideClick);
        
        // Remove existing menu click listener to prevent duplicates
        mobileMenu.removeEventListener('click', mobileMenu._menuClickHandler);
        
        // Prevent clicks inside mobile menu from closing it
        mobileMenu._menuClickHandler = function(e) {
            console.log('[Mobile Menu] Menu click event, stopping propagation');
            e.stopPropagation();
        };
        
        // Add the menu click listener
        mobileMenu.addEventListener('click', mobileMenu._menuClickHandler);
    } else {
        console.log('[Mobile Menu] ERROR: Button or menu element not found!');
    }
});
</script>