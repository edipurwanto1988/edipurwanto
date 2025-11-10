@props(['headings' => []])

@if (count($headings) > 0)
    <nav class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24 max-w-full">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Isi</h2>
            <div class="w-8 h-px bg-gray-200"></div>
        </div>
        
        <div class="space-y-1 max-h-[calc(100vh-200px)] overflow-y-auto">
            {{-- Only show H2 headings (level 2) --}}
            @foreach ($headings as $heading)
                @if($heading['level'] == 2)
                    <a
                        href="#{{ $heading['id'] }}"
                        class="block py-1.5 px-3 rounded-md transition-all duration-150 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 pl-6 bg-white"
                    >
                        <span class="truncate">{{ $heading['text'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </nav>
@endif
