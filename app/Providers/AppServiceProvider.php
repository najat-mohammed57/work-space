<?php

namespace App\Providers;

use App\Models\Customer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
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
        Paginator::useBootstrapFive();

        Route::bind('customer', function (string $value): Customer {
            return Customer::query()->whereKey($value)->firstOrFail();
        });
    }
}
