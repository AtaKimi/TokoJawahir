<?php

namespace App\Providers;

use App\Models\Store;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavbarViewComposerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('components.layouts.admin', function ($view) {
            $store = Store::first();
            $view->with('store', $store);
        });

        View::composer('components.layouts.guest', function ($view) {
            $store = Store::first();
            $view->with('store', $store);
        });
    }
}
