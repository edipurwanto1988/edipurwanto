<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'homepage_description',
        'google_console_code',
        'homepage_image_path',
        'favicon_path',
    ];

    public function getHomepageImageUrlAttribute(): ?string
    {
        if (! $this->homepage_image_path) {
            return null;
        }

        if (Str::startsWith($this->homepage_image_path, ['http://', 'https://'])) {
            return $this->homepage_image_path;
        }

        return Storage::disk('public')->url($this->homepage_image_path);
    }

    public function getFaviconUrlAttribute(): ?string
    {
        if (! $this->favicon_path) {
            return null;
        }

        if (Str::startsWith($this->favicon_path, ['http://', 'https://'])) {
            return $this->favicon_path;
        }

        return Storage::disk('public')->url($this->favicon_path);
    }
}
