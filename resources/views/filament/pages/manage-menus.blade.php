<x-filament-panels::page>
    <div class="grid gap-6 lg:grid-cols-4">
        <div class="space-y-4 lg:col-span-1">
            <div>
                <h3 class="text-sm font-semibold text-slate-600">Halaman Tersedia</h3>
                <p class="text-xs text-slate-500">Tambahkan halaman terbit ke menu dengan satu klik.</p>
            </div>
            <div class="space-y-2">
                @forelse ($this->availablePages as $page)
                    <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white px-3 py-2 shadow-sm">
                        <span class="text-sm font-medium text-slate-700">{{ $page->title }}</span>
                        <x-filament::button size="xs" wire:click="addPageToMenu({{ $page->id }})">
                            Tambah
                        </x-filament::button>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada halaman terbit.</p>
                @endforelse
            </div>
        </div>
        <div class="lg:col-span-3">
            <form wire:submit.prevent="submit" class="space-y-6">
                {{ $this->form }}

                <div class="flex justify-end">
                    <x-filament::button type="submit" color="primary">
                        Simpan Menu
                    </x-filament::button>
                </div>
            </form>
        </div>
    </div>
</x-filament-panels::page>
