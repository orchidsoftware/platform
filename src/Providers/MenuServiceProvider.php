<?php

namespace Orchid\Platform\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Http\Composers\MenuComposer;
use Orchid\Platform\Http\Composers\MenuComposer2;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * @internal param Dashboard $dashboard
     */
    public function boot()
    {
        View::composer('dashboard::layouts.dashboard', MenuComposer::class);
        View::composer('dashboard::layouts.dashboard', MenuComposer2::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
