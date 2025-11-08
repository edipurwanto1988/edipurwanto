<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable automatic timestamps since we're using custom column names
    
    // UUID configuration
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'createdAt',
        'updatedAt',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'categoryId');
    }
}
