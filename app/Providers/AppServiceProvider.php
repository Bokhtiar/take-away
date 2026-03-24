<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        Paginator::defaultView('pagination.tailwind');
        Paginator::defaultSimpleView('pagination.simple-tailwind');

        // Custom Blade directive for permission checking
        Blade::if('can', function (string $permission) {
            return can($permission);
        });
    }
}
