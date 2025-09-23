<?php

namespace App\Filament\Pages;

use App\Models\Menu;
use App\Models\Page as PageModel;
use BackedEnum;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
use UnitEnum;

class ManageMenus extends Page implements HasForms
{
    use InteractsWithForms;
    use InteractsWithFormActions;

    protected static ?string $title = 'Kelola Menu';

    protected static ?string $navigationLabel = 'Menus';

    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bars-3';

    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.manage-menus';

    public ?array $data = [];

    protected ?Menu $menu = null;

    public function mount(): void
    {
        $menu = $this->getMenuModel();

        $this->form->fill([
            'items' => $menu->items ?? [],
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Builder::make('items')
                    ->label('Struktur Menu')
                    ->blocks([
                        Block::make('page')
                            ->columns(2)
                            ->schema([
                                Select::make('page_id')
                                    ->label('Halaman')
                                    ->options(fn () => PageModel::query()
                                        ->orderBy('title')
                                        ->pluck('title', 'id'))
                                    ->required(),
                                TextInput::make('label')
                                    ->label('Label Menu')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->columnSpan(1),
                                Toggle::make('open_in_new_tab')
                                    ->label('Buka di tab baru')
                                    ->inline(false)
                                    ->columnSpanFull(),
                            ])
                            ->label(function (?array $state): string {
                                $label = data_get($state, 'data.label');

                                if ($label) {
                                    return $label;
                                }

                                $pageId = data_get($state, 'data.page_id');

                                if ($pageId && ($page = PageModel::find($pageId))) {
                                    return $page->title;
                                }

                                return 'Link Page';
                            }),
                        Block::make('custom')
                            ->columns(2)
                            ->schema([
                                TextInput::make('label')
                                    ->label('Label Menu')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('url')
                                    ->label('URL')
                                    ->required()
                                    ->url()
                                    ->columnSpanFull(),
                               Toggle::make('open_in_new_tab')
                                    ->label('Buka di tab baru')
                                    ->inline(false)
                                    ->columnSpanFull(),
                            ])
                            ->label(fn (?array $state): string => data_get($state, 'data.label') ?? data_get($state, 'data.url') ?? 'Link Kustom'),
                    ])
                    ->reorderable()
                    ->collapsible()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $state = $this->form->getState();

        $menu = $this->getMenuModel();
        $menu->items = $state['items'] ?? [];
        $menu->save();

        Notification::make()
            ->title('Menu utama berhasil diperbarui')
            ->success()
            ->send();
    }

    public function addPageToMenu(int $pageId): void
    {
        $page = PageModel::find($pageId);

        if (! $page) {
            return;
        }

        $state = $this->form->getState();
        $items = $state['items'] ?? [];

        $items[] = [
            'type' => 'page',
            'data' => [
                'page_id' => $page->id,
                'label' => $page->title,
                'open_in_new_tab' => false,
            ],
        ];

        $state['items'] = $items;
        $this->form->fill($state);
    }

    public function getAvailablePagesProperty(): Collection
    {
        return PageModel::query()
            ->where('status', 'published')
            ->orderBy('title')
            ->get();
    }

    protected function getMenuModel(): Menu
    {
        return $this->menu ??= Menu::query()->firstOrCreate([
            'slug' => 'primary',
        ], [
            'name' => 'Primary Menu',
            'items' => [],
        ]);
    }
}
