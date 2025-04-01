<?php

namespace App\Providers;

use App\Models\College;
use App\Models\User;
use App\Observers\CollegeObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register helper functions
        require_once app_path('Helpers/functions.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set a default string length for database migrations
        // This fixes the "Specified key was too long" error in MySQL
        Schema::defaultStringLength(191);
        
        // Use Bootstrap 5 for pagination styling
        Paginator::useBootstrap();
        
        // Register observers
        College::observe(CollegeObserver::class);
        User::observe(UserObserver::class);
    }
}
