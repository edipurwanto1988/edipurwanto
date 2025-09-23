<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageHomepageSettings extends Page implements HasForms
{
    use InteractsWithForms;
    use InteractsWithFormActions;

    protected static ?string $title = 'Homepage Settings';

    protected static ?string $navigationLabel = 'Homepage Settings';

    protected static ?string $slug = 'homepage-settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 99;

    protected string $view = 'filament.pages.manage-homepage-settings';

    public ?array $data = [];

    protected ?Setting $setting = null;

    public function mount(): void
    {
        $setting = $this->getSettingModel();

        $this->form->fill($setting->only([
            'homepage_description',
            'google_console_code',
            'homepage_image_path',
            'favicon_path',
        ]));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('homepage_description')
                    ->label('Deskripsi Homepage')
                    ->rows(4)
                    ->maxLength(2000)
                    ->helperText('Ditampilkan pada meta description dan bagian hero beranda.')
                    ->columnSpanFull(),
                TextInput::make('google_console_code')
                    ->label('Google Search Console Code')
                    ->maxLength(255)
                    ->helperText('Contoh: kode dari meta google-site-verification.'),
                FileUpload::make('homepage_image_path')
                    ->label('Gambar Homepage')
                    ->disk('public')
                    ->directory('homepage')
                    ->visibility('public')
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth(1200)
                    ->imageResizeTargetHeight(800)
                    ->maxSize(4096)
                    ->getUploadedFileNameForStorageUsing(fn ($file) => (string) Str::uuid() . '.' . $file->getClientOriginalExtension())
                    ->preserveFilenames(false)
                    ->downloadable()
                    ->openable()
                    ->helperText('Sebaiknya rasio landscape 3:2, ukuran maksimal 4MB.'),
                FileUpload::make('favicon_path')
                    ->label('Favicon')
                    ->disk('public')
                    ->directory('favicons')
                    ->visibility('public')
                    ->image()
                    ->imageEditor()
                    ->imageResizeTargetWidth(512)
                    ->imageResizeTargetHeight(512)
                    ->maxSize(1024)
                    ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/svg+xml'])
                    ->downloadable()
                    ->openable()
                    ->helperText('Gunakan gambar square (512x512 atau SVG), ukuran maksimal 1MB.'),
            ])
            ->statePath('data')
            ->model($this->getSettingModel());
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $setting = $this->getSettingModel();

        $oldImage = $setting->homepage_image_path;
        $newImage = $data['homepage_image_path'] ?? null;
        $oldFavicon = $setting->favicon_path;
        $newFavicon = $data['favicon_path'] ?? null;

        if ($oldImage && $oldImage !== $newImage) {
            Storage::disk('public')->delete($oldImage);
        }

        if ($oldFavicon && $oldFavicon !== $newFavicon) {
            Storage::disk('public')->delete($oldFavicon);
        }

        $setting->fill($data);
        $setting->save();

        Notification::make()
            ->title('Pengaturan tersimpan')
            ->success()
            ->send();
    }

    protected function getSettingModel(): Setting
    {
        return $this->setting ??= Setting::query()->firstOrCreate([]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importWordPress')
                ->label('Import Artikel WordPress')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Import Artikel dari WordPress')
                ->modalSubheading('Proses ini akan menarik artikel terbaru dari database WordPress (blog_edi_wp) dan menimpa data dengan slug yang sama.')
                ->modalButton('Mulai Import')
                ->action(fn () => $this->importWordPressArticles())
                ->disabled(fn () => ! $this->canRunWordPressImport())
                ->tooltip('Menjalankan migrasi artikel dari WordPress ke aplikasi ini'),
            Action::make('regenerateThumbnails')
                ->label('Regenerate Thumbnail Artikel')
                ->icon('heroicon-o-photo')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Regenerasi Thumbnail Artikel')
                ->modalSubheading('Tindakan ini akan menghapus thumbnail artikel lama kemudian menghasilkan ulang versi baru berukuran 256x176.')
                ->modalButton('Mulai Regenerasi')
                ->action(fn () => $this->regenerateThumbnails())
                ->tooltip('Hasilkan ulang semua thumbnail artikel pada ukuran terbaru'),
            Action::make('bantu')
                ->label('Butuh Bantuan?')
                ->icon('heroicon-o-question-mark-circle')
                ->color('primary')
                ->url('mailto:admin@edipurwanto.com?subject=Permintaan%20Bantuan%20Homepage')
                ->tooltip('Hubungi admin bila memerlukan bantuan pengaturan beranda')
                ->openUrlInNewTab(),
        ];
    }

    protected function canRunWordPressImport(): bool
    {
        return app()->bound('db') && config('database.connections.wp.database');
    }

    protected function importWordPressArticles(): void
    {
        try {
            Artisan::call('wordpress:import', [
                '--force' => true,
                '--no-progress' => true,
            ]);

            $output = Str::of(Artisan::output())
                ->trim()
                ->explode(PHP_EOL)
                ->filter()
                ->take(-3)
                ->implode('\n');

            Notification::make()
                ->title('Import selesai')
                ->success()
                ->body($output ?: 'Artikel berhasil diimport dari WordPress.')
                ->send();
        } catch (\Throwable $exception) {
            report($exception);

            Notification::make()
                ->title('Import gagal')
                ->danger()
                ->body($exception->getMessage())
                ->send();
        }
    }

    protected function regenerateThumbnails(): void
    {
        try {
            Artisan::call('articles:regenerate-thumbnails');

            $output = Str::of(Artisan::output())
                ->trim()
                ->explode(PHP_EOL)
                ->filter()
                ->take(-3)
                ->implode('\n');

            Notification::make()
                ->title('Thumbnail selesai dibuat ulang')
                ->success()
                ->body($output ?: 'Seluruh thumbnail artikel telah diperbarui.')
                ->send();
        } catch (\Throwable $exception) {
            report($exception);

            Notification::make()
                ->title('Regenerasi gagal')
                ->danger()
                ->body($exception->getMessage())
                ->send();
        }
    }
}
