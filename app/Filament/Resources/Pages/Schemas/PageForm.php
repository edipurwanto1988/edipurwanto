<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
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
                    ->afterStateUpdated(function (?string $state, callable $set, string $operation): void {
                        if ($operation !== 'create') {
                            return;
                        }

                        if (blank($state)) {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Digunakan pada URL, mis. /pages/slug-anda'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required(),
                TextInput::make('seo_title')
                    ->label('Judul SEO')
                    ->maxLength(255),
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
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('content_html', $state))
                                ->extraInputAttributes([
                                    'class' => 'min-h-[500px]',
                                    'style' => 'min-height: 500px;',
                                ]),
                        ]),
                        Tab::make('HTML')->schema([
                            Textarea::make('content_html')
                                ->label('Konten HTML')
                                ->rows(16)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('content', $state))
                                ->helperText('Edit langsung versi HTML. Perubahan akan tersimpan ke editor.'),
                        ]),
                    ])
                    ->columnSpanFull()
                    ->contained(false),
            ])
            ->statePath('data');
    }
}
