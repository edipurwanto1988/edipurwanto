<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

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
