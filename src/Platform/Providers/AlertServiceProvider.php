<?php

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Alert\Alert;
use Orchid\Platform\Alert\SessionStoreInterface;
use Orchid\Platform\Alert\LaravelSessionStore;

/**
 * Class AlertServiceProvider.
 *
 * @category PHP
 */
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
        $this->app->bind(SessionStoreInterface::class, LaravelSessionStore::class);

        $this->app->singleton('alert', function () {
            return $this->app->make(Alert::class);
        });
    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        //
    }
}
