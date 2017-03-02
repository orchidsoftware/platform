<?php

namespace Orchid\Log;

use Illuminate\Support\ServiceProvider;
use Orchid\Log\Providers\UtilitiesServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Get the base path.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(Contracts\Log::class, Log::class);
        $this->app->singleton('arcanedev.log-viewer', Contracts\Log::class);
        $this->app->alias('arcanedev.log-viewer', Facades\Log::class);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->register(UtilitiesServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Contracts\Log::class,
        ];
    }
}
