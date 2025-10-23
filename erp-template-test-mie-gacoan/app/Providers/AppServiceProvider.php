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
        $this->loadMigrationsFrom([
            database_path('migrations'),
            database_path('migrations/UserManagement'),
            database_path('migrations/CompanyManagement'),
            database_path('migrations/Finance'),
            database_path('migrations/Inventory'),
            database_path('migrations/Production'),
            database_path('migrations/Purchasing'),
    ]);
    }
}
