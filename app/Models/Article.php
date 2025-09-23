<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'category_id',
        'thumbnail_url',
        'thumbnail_path',
        'thumbnail_thumb_path',
        'excerpt',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailUrlAttribute(?string $value): ?string
    {
        $this->ensureThumbnailGenerated();

        if ($value && Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        if ($value) {
            return Storage::disk('public')->url($value);
        }

        if ($this->thumbnail_path) {
            return Storage::disk('public')->url($this->thumbnail_path);
        }

        return null;
    }

    public function getThumbnailThumbUrlAttribute(): ?string
    {
        $this->ensureThumbnailGenerated();

        $path = $this->thumbnail_thumb_path ?? $this->attributes['thumbnail_url'] ?? null;

        if ($path && Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if ($path) {
            return Storage::disk('public')->url($path);
        }

        if ($this->thumbnail_path) {
            return Storage::disk('public')->url($this->thumbnail_path);
        }

        return null;
    }

    public function getThumbnailOriginalUrlAttribute(): ?string
    {
        $this->ensureThumbnailGenerated();

        if ($this->thumbnail_path) {
            return Storage::disk('public')->url($this->thumbnail_path);
        }

        return $this->thumbnail_url;
    }

    protected function ensureThumbnailGenerated(): void
    {
        if ($this->thumbnail_thumb_path || ! $this->thumbnail_path) {
            return;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($this->thumbnail_path)) {
            return;
        }

        $extension = pathinfo($this->thumbnail_path, PATHINFO_EXTENSION) ?: 'jpg';
        $thumbPath = Str::of($this->thumbnail_path)
            ->beforeLast('.')
            ->append('-thumb.')
            ->append($extension)
            ->value();

        if (! $disk->exists($thumbPath)) {
            $image = Image::read($disk->path($this->thumbnail_path));
            $image->cover(256, 176);
            $image->save($disk->path($thumbPath));
        }

        $this->forceFill([
            'thumbnail_thumb_path' => $thumbPath,
            'thumbnail_url' => $this->thumbnail_path,
        ])->saveQuietly();
    }
}
