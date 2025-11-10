@extends('layouts.app')

@php
    $settings = $settings ?? null;
    $metaDescription = $metaDescription
        ?? $article->excerpt
        ?? \Illuminate\Support\Str::limit(strip_tags((string) ($article->content ?? '')), 160);
    
    // DEBUG: Log the raw image_url value
    \Log::info('Article Image URL Debug', [
        'raw_image_url' => $article->image_url,
        'image_url_attribute' => $article->image_url,
        'model_accessor' => $article->getImageUrlAttribute(),
        'storage_exists' => $article->image_url ? Storage::disk('public')->exists($article->image_url) : false,
        'final_url' => null // Will be set below
    ]);
    
    // Article-specific meta tags
    $articleImageUrl = $article->image_url ?? asset('images/edipurwanto.jpeg');
    
    // DEBUG: Log the final URL
    \Log::info('Final Article Image URL', ['final_url' => $articleImageUrl]);
    
    $articlePublishedDate = optional($article->publishedAt)->format('Y-m-d') ?? optional($article->createdAt)->format('Y-m-d');
    $articleModifiedDate = optional($article->updatedAt)->format('Y-m-d') ?? $articlePublishedDate;
@endphp

@push('meta')
    <!-- Article specific meta tags -->
    <meta property="og:type" content="article">
    <meta property="article:published_time" content="{{ $articlePublishedDate }}T{{ optional($article->publishedAt)->format('H:i:s') ?? '00:00:00' }}+07:00">
    <meta property="article:modified_time" content="{{ $articleModifiedDate }}T{{ optional($article->updatedAt)->format('H:i:s') ?? optional($article->publishedAt)->format('H:i:s') ?? '00:00:00' }}+07:00">
    <meta property="article:author" content="Edi Purwanto">
    @if ($article->category)
        <meta property="article:section" content="{{ $article->category->name }}">
    @endif
    <meta property="og:image" content="{{ $articleImageUrl }}">
    <meta property="og:image:width" content="{{ strlen($article->thumbnail_original_url ?? $article->thumbnail_url) > 0 ? '800' : '400' }}">
    <meta property="og:image:height" content="{{ strlen($article->thumbnail_original_url ?? $article->thumbnail_url) > 0 ? '600' : '400' }}">
    <meta property="twitter:image" content="{{ $articleImageUrl }}">
    <meta property="twitter:image:alt" content="Gambar {{ $article->title }}">
@endpush

@section('content')
<article class="px-4 py-8">
    <div class="mb-10">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Beranda
        </a>
    </div>

    <header class="space-y-6 mb-8">
        <div class="flex flex-wrap items-center gap-3 text-xs font-medium text-text-light">
            <span>{{ optional($article->publishedAt)->translatedFormat('d M Y') ?? optional($article->createdAt)->translatedFormat('d M Y') ?? 'Tanggal tidak tersedia' }}</span>
            @if ($article->category)
                <span>•</span>
                <a href="{{ route('categories.show', $article->category->slug) }}" class="text-primary hover:underline">
                    {{ $article->category->name }}
                </a>
            @endif
        </div>

        <h1 class="text-3xl font-bold tracking-tight text-text-dark sm:text-4xl">
            {{ $article->title }}
        </h1>

        @if ($article->excerpt)
            <p class="text-base text-text-light">{{ $article->excerpt }}</p>
        @endif
    </header>

    @if ($article->thumbnail_original_url ?? $article->thumbnail_url)
        <figure class="mb-10 overflow-hidden rounded-xl border border-gray-200/80 shadow-sm">
            <img src="{{ $article->thumbnail_original_url ?? $article->thumbnail_url }}" alt="Gambar {{ $article->title }}" class="h-auto w-full object-cover" loading="lazy">
        </figure>
    @endif

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

    @if (! empty($contentWithToc))
        <div class="prose prose-lg max-w-none prose-headings:font-semibold prose-a:text-primary hover:prose-a:underline">
            {!! $contentWithToc !!}
        </div>
    @endif
</article>
@endsection
