<?php

namespace Orchid\Log;

use Illuminate\Support\ServiceProvider;
use Orchid\Log\Providers\UtilitiesServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'log-viewer';

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
        //$this->registerConfig();

        // $this->registerProvider(Providers\UtilitiesServiceProvider::class);
        $this->registerLog();
        //$this->registerAliases();
        //$this->registerConsoleServiceProvider(Providers\CommandsServiceProvider::class);
    }

    /**
     * Register the log data class.
     */
    private function registerLog()
    {
        $this->app->singleton(Contracts\Log::class, Log::class);
        $this->app->singleton('arcanedev.log-viewer', Contracts\Log::class);
        //$this->app->singleton(Log::class);
        $this->app->alias('arcanedev.log-viewer', Facades\Log::class);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        //$this->publishConfig();
        //$this->publishViews();
        //$this->publishTranslations();
        $this->app->register(UtilitiesServiceProvider::class);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Services Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arcanedev.log-viewer',
            Contracts\Log::class,
        ];
    }
}
