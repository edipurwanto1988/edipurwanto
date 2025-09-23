<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kategori - Blog Edi Purwanto</title>
    @php($settings = $settings ?? null)
    <meta name="description" content="Kumpulan kategori artikel Blog Edi Purwanto.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?display=swap&amp;family=Newsreader:wght@400;500;700;800&amp;family=Noto+Sans:wght@400;500;700;900" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1193d4',
                        'background-light': '#f6f7f8',
                        'background-dark': '#101c22',
                    },
                    fontFamily: {
                        display: ['Newsreader', 'serif'],
                        sans: ['Noto Sans', 'ui-sans-serif', 'system-ui'],
                    },
                    borderRadius: { DEFAULT: '0.125rem', lg: '0.25rem', xl: '0.5rem', full: '0.75rem' },
                },
            },
        };
    </script>
    @if ($favicon = $settings?->favicon_url)
        <link rel="icon" href="{{ $favicon }}">
    @endif
    @if (! empty($settings?->google_console_code))
        <meta name="google-site-verification" content="{{ $settings->google_console_code }}">
    @endif
</head>
<body class="bg-background-light font-sans text-zinc-900 antialiased dark:bg-background-dark dark:text-zinc-200">
<div class="flex min-h-screen w-full flex-col">
    <header class="sticky top-0 z-10 w-full border-b border-zinc-200/50 bg-background-light/80 backdrop-blur-sm dark:border-zinc-800/50 dark:bg-background-dark/80">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 text-zinc-900 dark:text-zinc-100">
                    <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor" />
                    </svg>
                    <span class="text-xl font-bold">Blog Edi Purwanto</span>
                </a>
            </div>
            <nav class="hidden items-center gap-6 md:flex">
                @forelse(($menuItems ?? collect()) as $item)
                    <a href="{{ $item['url'] }}"
                       @class([
                           'text-sm font-medium transition-colors',
                           'text-primary' => request()->fullUrlIs($item['url']),
                           'text-zinc-600 hover:text-primary dark:text-zinc-400 dark:hover:text-primary' => ! request()->fullUrlIs($item['url']),
                       ])
                       @if(!empty($item['open_in_new_tab'])) target="_blank" rel="noopener" @endif>
                        {{ $item['label'] }}
                    </a>
                @empty
                    <a href="{{ url('/') }}" class="text-sm font-medium text-zinc-600 transition-colors hover:text-primary dark:text-zinc-400 dark:hover:text-primary">Home</a>
                    <a href="{{ url('/#articles') }}" class="text-sm font-medium text-zinc-600 transition-colors hover:text-primary dark:text-zinc-400 dark:hover:text-primary">Articles</a>
                    <a href="{{ route('categories.index') }}" class="text-sm font-medium text-primary">Kategori</a>
                    <a href="{{ url('/#contact') }}" class="text-sm font-medium text-zinc-600 transition-colors hover:text-primary dark:text-zinc-400 dark:hover-text-primary">Kontak</a>
                @endforelse
            </nav>
        </div>
    </header>

    <main class="flex-1">
        <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
            <header class="mb-10 text-center">
                <span class="inline-flex items-center justify-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary">
                    Kategori
                </span>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-4xl">
                    Semua Kategori
                </h1>
                <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">Jelajahi topik yang dibahas di Blog Edi Purwanto.</p>
            </header>

            <div class="grid gap-6 md:grid-cols-2">
                @forelse ($categories as $category)
                    <article class="group relative flex h-full flex-col justify-between rounded-2xl border border-zinc-200/70 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-lg dark:border-zinc-800/70 dark:bg-background-dark">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-xs font-semibold text-primary">
                                <span>{{ $category->articles_count }} Artikel</span>
                                <span class="material-symbols-outlined text-base transition group-hover:translate-x-1">arrow_forward</span>
                            </div>
                            <h2 class="text-xl font-bold leading-snug text-zinc-900 transition group-hover:text-primary dark:text-zinc-100">
                                <a href="{{ route('categories.show', $category->slug) }}" class="block">{{ $category->name }}</a>
                            </h2>
                            @if ($category->description)
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $category->description }}</p>
                            @endif
                        </div>
                        <ul class="mt-6 space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                            @forelse ($category->articles->take(4) as $article)
                                <li>
                                    <a href="{{ route('articles.show', $article->slug) }}" class="inline-flex items-center gap-2 hover:text-primary">
                                        <span class="material-symbols-outlined text-xs">fiber_manual_record</span>
                                        <span>{{ $article->title }}</span>
                                    </a>
                                </li>
                            @empty
                                <li class="text-zinc-400">Belum ada artikel.</li>
                            @endforelse
                        </ul>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-zinc-300 p-10 text-center text-zinc-500 dark:border-zinc-700 dark:text-zinc-400 md:col-span-2">
                        Belum ada kategori yang tersedia.
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200/70 bg-background-light py-8 text-center text-sm text-zinc-500 dark:border-zinc-800/70 dark:bg-background-dark dark:text-zinc-500">
        © {{ date('Y') }} Blog Edi Purwanto
    </footer>
</div>
</body>
</html>
