@extends('layouts.app')

@section('content')
<article class="px-4 py-8">
    <div class="mb-10">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Beranda
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-8">
        <h1 class="text-3xl font-bold tracking-tight text-text-dark sm:text-4xl mb-6">
            {{ $page->title }}
        </h1>
        
        @if ($page->content)
            <div class="prose prose-lg max-w-none prose-headings:font-semibold prose-a:text-primary hover:prose-a:underline">
                {!! $page->content !!}
            </div>
        @else
            <p class="text-text-light">Konten belum tersedia.</p>
        @endif
    </div>
</article>
@endsection
