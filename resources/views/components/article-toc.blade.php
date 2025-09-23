@props(['headings' => []])

@if (count($headings) >= 3)
    <aside class="my-8 rounded-2xl border border-zinc-200/70 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-zinc-800/70 dark:bg-background-dark">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-primary">Daftar Isi</h2>
        <ul class="mt-4 space-y-3 text-sm">
            @foreach ($headings as $heading)
                <li>
                    <a href="#{{ $heading['id'] }}" class="inline-flex items-center gap-2 text-zinc-600 transition hover:text-primary dark:text-zinc-300 dark:hover:text-primary">
                        <span class="material-symbols-outlined text-base">chevron_right</span>
                        <span>{{ $heading['text'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>
@endif
