<?php

namespace App\Blade;

use App\Support\ViteFallback;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Vite;

class ViteDirective
{
    /**
     * Register the custom Vite directive
     */
    public static function register()
    {
        Blade::directive('vite', function ($expression) {
            // Try normal Vite first
            try {
                $vite = Vite::withEntryPoints(['resources/js/app.js']);
                return "<?php echo {$vite}->{$expression}; ?>";
            } catch (\Exception $e) {
                // Fallback to our custom solution
                return "<?php echo \\App\\Support\\ViteFallback::withFallback({$expression})->toHtml(); ?>";
            }
        });
    }
}