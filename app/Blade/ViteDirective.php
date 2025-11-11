<?php

namespace App\Blade;

use App\Support\ViteFallback;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\HtmlString;

class ViteDirective
{
    /**
     * Register the custom Vite directive
     */
    public static function register()
    {
        // Don't override the built-in @vite directive - just provide fallback functionality
        // The built-in directive will work normally, and our ViteFallback class handles errors
    }
}