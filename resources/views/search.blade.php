@extends('layouts.app')

@section('content')
<div class="flex w-full flex-col gap-6 @[520px]:flex-row @[520px]:justify-between @[520px]:items-center mb-8">
    <div class="flex flex-col @[520px]:flex-row gap-6 items-center @[520px]:items-start text-center @[520px]:text-left">
        <img class="rounded-full h-32 w-32 object-cover border-2 border-primary/40" data-alt="Professional headshot of Edi Purwanto" src="{{ asset('images/edipurwanto.jpeg') }}">
        <div class="flex flex-col justify-center space-y-2">
            <p class="text-text-dark text-3xl font-bold leading-tight tracking-[-0.015em]">Edi Purwanto</p>
            <p class="text-primary text-lg font-medium leading-normal">Information Systems Lecturer & System Analyst</p>
            <p class="text-text-light text-base font-normal leading-relaxed max-w-full">
                A dedicated lecturer in Information Systems with a deep passion for teaching, technology, and innovation. Beyond academia, I work as a System Analyst at a software house, where I bridge the gap between business needs and technical solutions.

This blog is where I share my experiences, research insights, and practical approaches to system design, data-driven decision making, and software development — combining the academic perspective with real-world industry practice.
            </p>
        </div>
    </div>
</div>

<div class="px-4">
    <div class="mb-10">
        <h1 class="text-3xl font-bold tracking-tight text-text-dark sm:text-4xl">
            Hasil Pencarian
        </h1>
        <p class="mt-2 text-lg text-text-light">
            Menampilkan hasil untuk: <span class="font-semibold text-primary">"{{ $query }}"</span>
        </p>
    </div>

    <div class="space-y-10">
        @forelse ($articles as $article)
            <article class="group grid grid-cols-1 gap-6 md:grid-cols-3 md:gap-8">
                <div class="overflow-hidden rounded-lg md:col-span-1">
                    <div class="h-full w-full bg-cover bg-center transition-transform duration-300 group-hover:scale-105"
                         style="background-image: url('{{ $article->thumbnail_thumb_url ?? $article->thumbnail_url ?? asset('images/article-placeholder.jpg') }}'); aspect-ratio: 16/9;"></div>
                </div>
                <div class="flex flex-col md:col-span-2">
                    <h2 class="text-xl font-bold text-text-dark transition-colors group-hover:text-primary">
                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                    </h2>
                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs font-medium text-text-light">
                        <span>{{ optional($article->publishedAt)->translatedFormat('d M Y') ?? optional($article->createdAt)->translatedFormat('d M Y') ?? 'Tanggal tidak tersedia' }}</span>
                        @if ($article->category)
                            <span class="text-text-light">·</span>
                            <a href="{{ route('categories.show', $article->category->slug) }}" class="text-primary hover:underline">
                                {{ $article->category->name }}
                            </a>
                        @endif
                    </div>
                    @if ($article->excerpt)
                        <p class="mt-3 text-sm text-text-light">{{ $article->excerpt }}</p>
                    @endif
                </div>
            </article>
        @empty
            <div class="rounded-lg border border-dashed border-gray-300 p-8 text-center text-text-light">
                <span class="material-symbols-outlined text-4xl mb-4 block">search_off</span>
                <h3 class="text-lg font-semibold mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-sm">Tidak ada artikel yang cocok dengan pencarian "{{ $query }}". Coba gunakan kata kunci lain.</p>
                <div class="mt-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-full bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @includeWhen($articles instanceof \Illuminate\Pagination\AbstractPaginator, 'components.pagination', ['paginator' => $articles])
</div>
@endsection