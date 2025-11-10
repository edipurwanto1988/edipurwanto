<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Menu;

// Helper function for dynamic image URL generation
if (!function_exists('getDynamicImageUrl')) {
    function getDynamicImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If the path is already a full URL, return it as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Check if we're in local development environment
        if (app()->environment('local')) {
            // For local development, use the current request host
            $currentHost = request()->getHost();
            $currentScheme = request()->isSecure() ? 'https' : 'http';
            return $currentScheme . '://' . $currentHost . '/storage/' . $path;
        } else {
            // For production, use the configured APP_URL
            return url('/storage/' . $path);
        }
    }
}

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share menu items with all views
        View::composer('*', function ($view) {
            $menuItems = optional(Menu::query()->where('slug', 'primary')->first())->resolved_items;
            $view->with('menuItems', $menuItems);
        });
    }
}
