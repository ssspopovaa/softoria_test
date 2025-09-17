<?php

namespace App\Providers;

use App\Services\ResellerApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ResellerApiClient::class, function ($app) {
            return new ResellerApiClient(
                config('services.dataimpulse.baseUrl'),
                config('services.dataimpulse.token')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
