<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MercadoPagoServiceProvider extends ServiceProvider implements DeferrableProvider
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

    public function provides(): array
    {
        return ['MercadoPagoService'];
    }

}   
