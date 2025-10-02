<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - Blog Edi Purwanto</title>
    @php
        $settings = $settings ?? null;
        $metaDescription = $metaDescription
            ?? $article->excerpt
            ?? \Illuminate\Support\Str::limit(strip_tags((string) ($article->content ?? '')), 160);
        $readingTime = max(1, (int) ceil(str_word_count(strip_tags($article->content ?? '')) / 200));
    @endphp
    <meta name="description" content="{{ $metaDescription }}">
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
                    <a href="{{ url('/#contact') }}" class="text-sm font-medium text-zinc-600 transition-colors hover:text-primary dark:text-zinc-400 dark:hover:text-primary">Kontak</a>
                @endforelse
            </nav>
            <div class="flex items-center gap-4">
                <form action="{{ route('search') }}" method="GET" class="hidden md:flex items-center">
                    <div class="relative">
                        <input type="text"
                               name="q"
                               placeholder="Cari artikel..."
                               class="w-64 rounded-lg border border-zinc-300 bg-white px-4 py-2 pr-10 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary dark:border-zinc-700 dark:bg-background-dark dark:text-zinc-100">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-primary dark:text-zinc-400">
                            <span class="material-symbols-outlined text-lg">search</span>
                        </button>
                    </div>
                </form>
                @php($profileImage = $settings?->homepage_image_url ?? null)
                <div class="h-10 w-10 rounded-full bg-cover bg-center" style="background-image: url('{{ $profileImage ?? asset('images/avatar-placeholder.svg') }}');"></div>
            </div>
        </div>
    </header>

    @php
        $contentHtml = $contentHtml ?? '';
        $tocHeadings = $headings ?? [];
        $contentWithToc = $contentHtml;

        if (count($tocHeadings) >= 3) {
            $firstParagraphPos = stripos($contentHtml, '</p>');
            $tocHtml = view('components.article-toc', ['headings' => $tocHeadings])->render();

            if ($firstParagraphPos !== false) {
                $contentWithToc = substr($contentHtml, 0, $firstParagraphPos + 4)
                    . $tocHtml
                    . substr($contentHtml, $firstParagraphPos + 4);
            } else {
                $contentWithToc = $tocHtml . $contentHtml;
            }
        }
    @endphp

    <main class="flex-1">
        <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Kembali ke Beranda
                </a>
            </div>

            <header class="space-y-6">
                <div class="flex flex-wrap items-center gap-3 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                    <span>{{ optional($article->published_at)->translatedFormat('d M Y') ?? optional($article->created_at)->translatedFormat('d M Y') ?? 'Tanggal tidak tersedia' }}</span>
                    @if ($article->category)
                        <span>•</span>
                        <a href="{{ route('categories.show', $article->category->slug) }}" class="text-primary hover:underline">
                            {{ $article->category->name }}
                        </a>
                    @endif
                    <span>•</span>
                    <span>{{ $readingTime }} menit baca</span>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-4xl">
                    {{ $article->title }}
                </h1>

                @if ($article->excerpt)
                    <p class="text-base text-zinc-600 dark:text-zinc-400">{{ $article->excerpt }}</p>
                @endif
            </header>

            @if ($article->thumbnail_original_url ?? $article->thumbnail_url)
                <figure class="my-10 overflow-hidden rounded-2xl border border-zinc-200/60 shadow-sm dark:border-zinc-800/60">
                    <img src="{{ $article->thumbnail_original_url ?? $article->thumbnail_url }}" alt="Gambar {{ $article->title }}" class="h-auto w-full object-cover" loading="lazy">
                </figure>
            @endif

            @if (! empty($contentWithToc))
                <div class="prose prose-zinc max-w-none prose-headings:font-semibold prose-a:text-primary hover:prose-a:underline dark:prose-invert">
                    {!! $contentWithToc !!}
                </div>
            @endif
        </article>
    </main>

    <footer class="border-t border-zinc-200/70 bg-background-light py-8 text-center text-sm text-zinc-500 dark:border-zinc-800/70 dark:bg-background-dark dark:text-zinc-500">
        © {{ date('Y') }} Blog Edi Purwanto | <a href="https://jasawebpekanbaru.com" target="_blank" class="text-blue-400 hover:text-blue-300 transition">Jasa Pembuatan Website Pekanbaru</a>
    </footer>
</div>
</body>
</html>
