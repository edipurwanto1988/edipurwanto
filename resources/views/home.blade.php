@extends('layouts.app')

@section('content')
@if(request()->get('page', 1) <= 1)
<div class="flex p-4 md:p-8 @container my-8">
<div class="flex w-full flex-col gap-6 @[520px]:flex-row @[520px]:justify-between @[520px]:items-center">
<div class="flex flex-col @[520px]:flex-row gap-6 items-center @[520px]:items-start text-center @[520px]:text-left">
<img class="rounded-full h-32 w-32 object-cover border-2 border-primary/40" data-alt="Professional headshot of Edi Purwanto" src="{{ asset('images/edipurwanto.jpeg') }}"/>
<div class="flex flex-col justify-center space-y-2">
<p class="text-text-dark text-3xl font-bold leading-tight tracking-[-0.015em]">Edi Purwanto</p>
<p class="text-primary text-lg font-medium leading-normal">🎓 Information Systems Lecturer & System Analyst</p>
<p class="text-text-light text-base font-normal leading-relaxed max-w-full">
                                            A dedicated lecturer in Information Systems with a deep passion for teaching, technology, and innovation. Beyond academia, I work as a System Analyst at a software house, where I bridge the gap between business needs and technical solutions.

This blog is where I share my experiences, research insights, and practical approaches to system design, data-driven decision making, and software development — combining the academic perspective with real-world industry practice.
                                        </p>
</div>
</div>
</div>
</div>
@endif
<h2 class="text-text-dark text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Latest Articles</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
@forelse ($articles as $article)
<div class="flex flex-col gap-3 pb-3 bg-white rounded-xl overflow-hidden border border-gray-200/80 hover:shadow-lg transition-shadow duration-300">
<div class="w-full bg-center bg-no-repeat aspect-video bg-cover" data-alt="Article thumbnail" style="background-image: url('{{ $article->thumbnail_thumb_url ?? $article->thumbnail ?? asset('images/article-placeholder.jpg') }}');"></div>
<div class="p-4 flex flex-col flex-grow">
<p class="text-text-dark text-lg font-medium leading-normal">
<a href="{{ route('articles.show', $article->slug) }}" class="hover:text-primary transition-colors">{{ $article->title }}</a>
</p>
<p class="text-text-light text-sm font-normal leading-normal mt-1 flex-grow">
{{ Str::limit(strip_tags($article->excerpt ?? $article->content ?? ''), 100) }}
                                    </p>
<p class="text-gray-400 text-xs font-normal leading-normal mt-3">Published on: {{ optional($article->publishedAt)->translatedFormat('M d, Y') ?? optional($article->createdAt)->translatedFormat('M d, Y') ?? 'Tanggal tidak tersedia' }}</p>
</div>
</div>
@empty
<div class="col-span-full text-center py-8 text-text-light">
<p>No articles found.</p>
</div>
@endforelse
</div>

@includeWhen($articles instanceof \Illuminate\Pagination\AbstractPaginator, 'components.pagination', ['paginator' => $articles])
@endsection
