<?php

namespace App\Providers;

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
        \Illuminate\Pagination\Paginator::useTailwind();
        
        // Share locations globally for search filters
        view()->composer('*', function ($view) {
            $view->with('allLocations', \App\Models\Store::whereNotNull('location')
                ->where('location', '!=', '')
                ->distinct()
                ->pluck('location')
                ->sort());
        });

        // Share header categories with all views (for mega menu)
        view()->composer('*', function ($view) {
            $view->with('headerCategories', \App\Models\Category::has('products')
                ->withCount('products')
                ->orderBy('name')
                ->get());
        });
    }
}
