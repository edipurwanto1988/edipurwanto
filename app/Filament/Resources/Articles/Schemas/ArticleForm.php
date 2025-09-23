<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->live(debounce: 300)
                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set): void {
                        if ($operation !== 'create') {
                            return;
                        }

                        if (blank($state)) {
                            $set('slug', null);

                            return;
                        }

                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->hint('Gunakan tanda hubung, mis. artikel-baru'),
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                FileUpload::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('articles')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(4096)
                    ->columnSpanFull()
                    ->getUploadedFileNameForStorageUsing(fn (TemporaryUploadedFile $file): string =>
                        (string) Str::uuid() . '.' . $file->getClientOriginalExtension()
                    )
                    ->afterStateUpdated(function (?string $state, Set $set): void {
                        if (blank($state)) {
                            $set('thumbnail_thumb_path', null);
                            $set('thumbnail_url', null);

                            return;
                        }

                        $disk = Storage::disk('public');

                        if (! $disk->exists($state)) {
                            return;
                        }

                        $extension = pathinfo($state, PATHINFO_EXTENSION);
                        $thumbPath = Str::of($state)
                            ->beforeLast('.')
                            ->append('-thumb.')
                            ->append($extension)
                            ->value();

                        $image = Image::read($disk->path($state));
                        $image->cover(112, 80);
                        $image->save($disk->path($thumbPath));

                        $set('thumbnail_thumb_path', $thumbPath);
                        $set('thumbnail_url', $state);
                    })
                    ->deleteUploadedFileUsing(function (?string $state): void {
                        if (blank($state)) {
                            return;
                        }

                        $disk = Storage::disk('public');

                        if ($disk->exists($state)) {
                            $disk->delete($state);
                        }

                        $extension = pathinfo($state, PATHINFO_EXTENSION);
                        $thumbPath = Str::of($state)
                            ->beforeLast('.')
                            ->append('-thumb.')
                            ->append($extension)
                            ->value();

                        if ($disk->exists($thumbPath)) {
                            $disk->delete($thumbPath);
                        }
                    })
                    ->required(fn (string $context): bool => $context === 'create')
                    ->hint('Maksimal 4MB, format JPG/PNG/WebP'),
                Hidden::make('thumbnail_thumb_path'),
                Hidden::make('thumbnail_url'),
                Textarea::make('excerpt')
                    ->label('Ringkasan')
                    ->rows(3)
                    ->columnSpanFull(),
                Tabs::make('content_tabs')
                    ->tabs([
                        Tab::make('Editor')->schema([
                            RichEditor::make('content')
                                ->label('Konten')
                                ->columnSpanFull()
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('content_html', $state))
                                ->extraInputAttributes([
                                    'class' => 'bg-amber-50/80 min-h-[500px]',
                                    'style' => 'min-height: 500px;',
                                ]),
                        ]),
                        Tab::make('HTML')->schema([
                            Textarea::make('content_html')
                                ->label('Konten HTML')
                                ->rows(16)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('content', $state))
                                ->helperText('Edit langsung versi HTML. Perubahan otomatis disinkronkan ke editor.'),
                        ]),
                    ])
                    ->columnSpanFull()
                    ->contained(false),
                DateTimePicker::make('published_at')
                    ->label('Tanggal terbit')
                    ->seconds(false)
                    ->time(false),
            ]);
    }
}
