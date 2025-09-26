<?php

namespace App\Providers;

use App\Contracts\ResellerApiClientInterface;
use App\Repositories\ResellerApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ResellerApiClientInterface::class, function ($app) {
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
