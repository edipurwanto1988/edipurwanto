<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($page->seo_title ?: $page->title) . ' - Blog Edi Purwanto' }}</title>
    <meta name="description" content="{{ $page->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 160) }}">
    @if ($favicon = $settings?->favicon_url)
        <link rel="icon" href="{{ $favicon }}">
    @endif
    @if (! empty($settings?->google_console_code))
        <meta name="google-site-verification" content="{{ $settings->google_console_code }}">
    @endif
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f8fafc;
            color: #1f2937;
        }
        header, main, footer {
            width: min(780px, 92vw);
            margin: 0 auto;
        }
        header {
            padding: 2rem 0 1.5rem;
        }
        .nav {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 20px;
            border: 1px solid rgba(99, 102, 241, 0.18);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.16) 0%, rgba(129, 140, 248, 0.1) 38%, rgba(255, 255, 255, 0.92) 100%);
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.14);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .nav::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.32), transparent 55%);
            pointer-events: none;
        }
        .nav > * {
            position: relative;
            z-index: 1;
        }
        .logo {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.01em;
            color: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 0.75rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.48);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .nav-menu a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1rem;
            border-radius: 14px;
            border: 1px solid transparent;
            background: rgba(255, 255, 255, 0.2);
            color: #52606d;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.22s ease;
        }
        .nav-menu a:hover {
            color: #312e81;
            background: rgba(99, 102, 241, 0.16);
            border-color: rgba(99, 102, 241, 0.24);
            box-shadow: 0 12px 26px rgba(99, 102, 241, 0.18);
            transform: translateY(-1px);
        }
        .nav-menu a.active {
            color: #1e1b4b;
            background: rgba(99, 102, 241, 0.22);
            border-color: rgba(99, 102, 241, 0.32);
            box-shadow: 0 16px 30px rgba(79, 70, 229, 0.22);
        }
        article {
            background: #fff;
            border-radius: 18px;
            padding: 2.5rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        }
        article h1 {
            margin-top: 0;
            font-size: clamp(2rem, 4vw, 2.6rem);
        }
        article p {
            line-height: 1.7;
            font-size: 1.05rem;
        }
        footer {
            padding: 2rem 0 3rem;
            color: #64748b;
            font-size: 0.9rem;
        }
        @media (max-width: 640px) {
            .nav {
                flex-direction: column;
                align-items: flex-start;
            }
            article {
                padding: 1.8rem;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="nav">
        <a class="logo" href="{{ url('/') }}">Blog Edi Purwanto</a>
        <nav class="nav-menu">
            @forelse(($menuItems ?? collect()) as $item)
                <a href="{{ $item['url'] }}" @if(!empty($item['open_in_new_tab'])) target="_blank" rel="noopener" @endif>
                    {{ $item['label'] }}
                </a>
            @empty
                <a href="{{ url('/') }}" @class(['active' => request()->is('/')])>Home</a>
                <a href="{{ url('/#articles') }}">Article</a>
                <a href="{{ route('categories.index') }}" @class(['active' => request()->routeIs('categories.index') || request()->routeIs('categories.show')])>Kategori</a>
                <a href="{{ url('/#contact') }}">Contact</a>
            @endforelse
        </nav>
    </div>
</header>

<main>
    <article>
        <h1>{{ $page->title }}</h1>
        @if ($page->content)
            {!! $page->content !!}
        @else
            <p>Konten belum tersedia.</p>
        @endif
    </article>
</main>

<footer>
    © {{ date('Y') }} Blog Edi Purwanto | <a href="https://jasawebpekanbaru.com" target="_blank" class="text-blue-400 hover:text-blue-300 transition">Jasa Pembuatan Website Pekanbaru</a>
</footer>
</body>
</html>
