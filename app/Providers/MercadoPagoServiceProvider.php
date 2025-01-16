<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MercadoPagoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('MercadoPagoService', function () {
            return new \App\Services\MercadoPagoService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->get('MercadoPagoService')->authenticate();
    }
}
