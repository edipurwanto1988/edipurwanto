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

    public $timestamps = false; // Disable automatic timestamps since we're using custom column names

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'slug',
        'title',
        'categoryId', // Changed from category_id
        'authorId', // Changed from author_id
        'image_url',
        'excerpt',
        'content',
        'publishedAt', // Changed from published_at
        'createdAt',
        'updatedAt',
    ];

    protected $casts = [
        'publishedAt' => 'datetime', // Changed from published_at
        'createdAt' => 'datetime', // Changed from created_at
        'updatedAt' => 'datetime', // Changed from updated_at
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function getImageUrlAttribute(): ?string
    {
        $value = $this->attributes['image_url'] ?? null;
        
        if ($value && Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        if ($value) {
            return Storage::disk('public')->url($value);
        }

        return null;
    }

    // Keep backward compatibility methods
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->image_url;
    }

    public function getThumbnailThumbUrlAttribute(): ?string
    {
        return $this->image_url;
    }

    public function getThumbnailOriginalUrlAttribute(): ?string
    {
        return $this->image_url;
    }
}
