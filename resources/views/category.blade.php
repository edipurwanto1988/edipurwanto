@extends('layouts.app')

@section('content')
<section class="px-4 py-8">
    <div class="mb-10">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Beranda
        </a>
    </div>

    <div class="rounded-xl border border-gray-200/80 bg-white p-8 shadow-sm mb-10">
        <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-primary">
            <span class="material-symbols-outlined text-base">category</span>
            Kategori
        </span>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-text-dark sm:text-4xl">
            {{ $category->name }}
        </h1>
        <p class="mt-3 text-sm text-text-light">
            {{ $category->description ?: 'Kumpulan tulisan dalam kategori ' . $category->name . '.' }}
        </p>
    </div>

    <div class="space-y-6">
        @forelse ($articles as $article)
            <article class="rounded-xl border border-gray-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-primary/40 hover:shadow-lg">
                <div class="flex flex-wrap items-center gap-3 text-xs font-medium text-text-light">
                    <span>{{ optional($article->publishedAt)->translatedFormat('d M Y') ?? optional($article->createdAt)->translatedFormat('d M Y') ?? 'Tanggal tidak tersedia' }}</span>
                    <span>•</span>
                    <span>{{ ceil(str_word_count(strip_tags($article->content ?? '')) / 200) }} menit baca</span>
                </div>
                <h2 class="mt-3 text-xl font-semibold text-text-dark transition group-hover:text-primary">
                    <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-primary">{{ $article->title }}</a>
                </h2>
                @if ($article->excerpt)
                    <p class="mt-3 text-sm text-text-light">{{ $article->excerpt }}</p>
                @endif
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-gray-300 p-10 text-center text-text-light">
                Belum ada artikel dalam kategori ini.
            </div>
        @endforelse
    </div>

    @includeWhen($articles instanceof \Illuminate\Pagination\AbstractPaginator, 'components.pagination', ['paginator' => $articles])
</section>
@endsection
