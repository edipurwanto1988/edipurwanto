<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog Edi Purwanto</title>
    @php($settings = $settings ?? null)
    <meta name="description" content="{{ $settings?->homepage_description ?? 'Blog personal berisi ide, catatan perjalanan, dan referensi.' }}">
    @if ($favicon = $settings?->favicon_url)
        <link rel="icon" href="{{ $favicon }}">
    @endif
    @if (! empty($settings?->google_console_code))
        <meta name="google-site-verification" content="{{ $settings->google_console_code }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?display=swap&amp;family=Newsreader:wght@400;500;700;800&amp;family=Noto+Sans:wght@400;500;700;900" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                    <a href="{{ url('/') }}" class="text-sm font-medium text-primary">Home</a>
                    <a href="{{ url('/#articles') }}" class="text-sm font-medium text-zinc-600 transition-colors hover:text-primary dark:text-zinc-400 dark:hover:text-primary">Articles</a>
                    <a href="{{ route('categories.index') }}" class="text-sm font-medium text-zinc-600 transition-colors hover:text-primary dark:text-zinc-400 dark:hover-text-primary">Kategori</a>
                    <a href="{{ url('/#contact') }}" class="text-sm font-medium text-zinc-600 transition-colors hover:text-primary dark:text-zinc-400 dark:hover:text-primary">Kontak</a>
                @endforelse
            </nav>
            <div class="flex items-center gap-4">
                @php($profileImage = $settings?->homepage_image_url ?? null)
                <div class="h-10 w-10 rounded-full bg-cover bg-center" style="background-image: url('{{ $profileImage ?? asset('images/avatar-placeholder.png') }}');"></div>
            </div>
        </div>
    </header>

    <main class="flex-1">
        <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            @if ($settings?->homepage_description)
                <div class="mb-10 rounded-full bg-primary/10 px-4 py-2 text-sm font-medium text-primary dark:bg-primary/20">
                    {{ $settings->homepage_description }}
                </div>
            @endif
            <h1 class="mb-8 text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-4xl">Artikel Terbaru</h1>

            <div class="space-y-10">
                @forelse ($articles as $article)
                    <article class="group grid grid-cols-1 gap-6 md:grid-cols-3 md:gap-8">
                        <div class="overflow-hidden rounded-lg md:col-span-1">
                            <div class="h-full w-full bg-cover bg-center transition-transform duration-300 group-hover:scale-105"
                                 style="background-image: url('{{ $article->thumbnail_thumb_url ?? $article->thumbnail_url ?? asset('images/article-placeholder.jpg') }}'); aspect-ratio: 16/9;"></div>
                        </div>
                        <div class="flex flex-col md:col-span-2">
                            <h2 class="text-xl font-bold text-zinc-900 transition-colors group-hover:text-primary dark:text-zinc-100 dark:group-hover:text-primary">
                                <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                            </h2>
                            <div class="mt-3 flex flex-wrap items-center gap-2 text-xs font-medium text-zinc-500 dark:text-zinc-500">
                                <span>{{ optional($article->published_at)->translatedFormat('d M Y') ?? $article->created_at->translatedFormat('d M Y') }}</span>
                                @if ($article->category)
                                    <span class="text-zinc-400">·</span>
                                    <a href="{{ route('categories.show', $article->category->slug) }}" class="text-primary hover:underline">
                                        {{ $article->category->name }}
                                    </a>
                                @endif
                            </div>
                            @if ($article->excerpt)
                                <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $article->excerpt }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="rounded-lg border border-dashed border-zinc-300 p-8 text-center text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                        Belum ada artikel yang diterbitkan.
                    </div>
                @endforelse
            </div>

            @includeWhen($articles instanceof \Illuminate\Pagination\AbstractPaginator, 'components.pagination', ['paginator' => $articles])
        </section>

        <section id="contact" class="border-t border-zinc-200/60 bg-white/80 py-12 dark:border-zinc-800/60 dark:bg-background-dark/80">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Kontak</h2>
                <div class="mt-5 rounded-xl border border-zinc-200/70 bg-white p-6 shadow-sm dark:border-zinc-800/70 dark:bg-background-dark">
                    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                        <div class="max-w-xl text-sm text-zinc-600 dark:text-zinc-400">
                            <p>Saya senang mendengar cerita, ide kolaborasi, maupun pertanyaan seputar tulisan di sini. Balasan biasanya saya kirim dalam 1x24 jam pada hari kerja.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="mailto:admin@edipurwanto.com" class="inline-flex items-center gap-2 rounded-full bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">
                                ✉️ Kirim Email
                            </a>
                            <a href="https://www.linkedin.com/in/edipurwantoofficial/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-600 transition hover:border-primary hover:text-primary dark:border-zinc-700 dark:text-zinc-300 dark:hover:border-primary dark:hover:text-primary">
                                LinkedIn
                            </a>
                            <a href="https://www.instagram.com" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-600 transition hover:border-primary hover:text-primary dark:border-zinc-700 dark:text-zinc-300 dark:hover:border-primary dark:hover:text-primary">
                                Instagram
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200/70 bg-background-light py-8 text-center text-sm text-zinc-500 dark:border-zinc-800/70 dark:bg-background-dark dark:text-zinc-500">
        © {{ date('Y') }} Blog Edi Purwanto
    </footer>
</div>
</body>
</html>
