<?php

namespace App\Providers;

use App\Models\MenuItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.app', function ($view): void {
            $menuItems = Schema::hasTable('menu_items')
                ? MenuItem::active()->orderBy('sort_order')->orderBy('id')->get()
                : collect();

            $view->with([
                'headerMenuItems' => $menuItems->where('location', 'header')->values(),
                'footerMenuItems' => $menuItems->where('location', 'footer')->values(),
            ]);
        });
    }
}
