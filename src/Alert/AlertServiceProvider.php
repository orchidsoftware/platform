<?php

namespace Orchid\Alert;

use Illuminate\Support\ServiceProvider;

class AlertServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(
            SessionStoreInterface::class,
            LaravelSessionStore::class
        );

        $this->app->singleton('alert', function () {
            return new Alert();
        });
    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
    }
}
