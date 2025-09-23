@if ($paginator instanceof \Illuminate\Pagination\AbstractPaginator && $paginator->hasPages())
    @php
        $showNumbers = method_exists($paginator, 'lastPage');
        $current = $paginator->currentPage();
    @endphp

    <nav class="pagination mt-12 flex items-center justify-center gap-2" aria-label="Navigasi halaman">
        @if ($paginator->onFirstPage())
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full text-zinc-400 dark:text-zinc-600" aria-disabled="true">
                <span class="material-symbols-outlined text-xl">chevron_left</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-zinc-500 transition hover:bg-primary/10 hover:text-primary dark:text-zinc-400 dark:hover:bg-primary/20">
                <span class="material-symbols-outlined text-xl">chevron_left</span>
            </a>
        @endif

        @if ($showNumbers)
            @php
                $last = $paginator->lastPage();
                $window = 2;
                $start = max(1, $current - $window);
                $end = min($last, $current + $window);
            @endphp

            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-sm font-medium text-zinc-600 transition hover:bg-primary/10 hover:text-primary dark:text-zinc-400 dark:hover:bg-primary/20">1</a>
                @if ($start > 2)
                    <span class="ellipsis text-zinc-500">…</span>
                @endif
            @endif

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-primary text-sm font-bold text-white" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $paginator->url($page) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-sm font-medium text-zinc-600 transition hover:bg-primary/10 hover:text-primary dark:text-zinc-400 dark:hover:bg-primary/20">{{ $page }}</a>
                @endif
            @endfor

            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="ellipsis text-zinc-500">…</span>
                @endif
                <a href="{{ $paginator->url($last) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-sm font-medium text-zinc-600 transition hover:bg-primary/10 hover:text-primary dark:text-zinc-400 dark:hover:bg-primary/20">{{ $last }}</a>
            @endif
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-zinc-500 transition hover:bg-primary/10 hover:text-primary dark:text-zinc-400 dark:hover:bg-primary/20">
                <span class="material-symbols-outlined text-xl">chevron_right</span>
            </a>
        @else
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full text-zinc-400 dark:text-zinc-600" aria-disabled="true">
                <span class="material-symbols-outlined text-xl">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
