@props(['headings' => []])

@if (count($headings) >= 3)
    <nav class="article-toc prose">
        <h2>Daftar Isi</h2>
        <ul>
            @foreach ($headings as $heading)
                <li class="toc-level-{{ $heading['level'] }}">
                    <a href="#{{ $heading['id'] }}">
                        {{ $heading['text'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif
