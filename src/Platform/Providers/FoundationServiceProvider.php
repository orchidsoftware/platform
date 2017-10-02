<?php

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Alert\Laravel\AlertServiceProvider;
use Orchid\Defender\Providers\DefenderServiceProvider;
use Orchid\Platform\Kernel\Dashboard;
use Watson\Active\ActiveServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->app->singleton(Dashboard::class, function () {
            return new Dashboard();
        });

        $this->registerDatabase();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        $this->registerProviders();
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(realpath(DASHBOARD_PATH . '/resources/lang'), 'dashboard');
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        if (config('platform.headless')) {
            return null;
        }

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/vendor/orchid/dashboard';
        }, config('view.paths')), [
            DASHBOARD_PATH . '/resources/views',
        ]), 'dashboard');
    }

    public function registerProviders()
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            RouteServiceProvider::class,
            ConsoleServiceProvider::class,
            PermissionServiceProvider::class,
            EventServiceProvider::class,
            MenuServiceProvider::class,
        ];
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        if (!defined('DASHBOARD_PATH')) {
            define('DASHBOARD_PATH', realpath(__DIR__ . '/../../'));
        }
    }

    /**
     * Register migrate.
     */
    protected function registerDatabase()
    {
        $this->publishes([
            realpath(DASHBOARD_PATH . '/resources/stubs/database/migrations/') => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            realpath(DASHBOARD_PATH . '/config/platform.php') => config_path('platform.php'),
        ]);

        $this->mergeConfigFrom(
            realpath(DASHBOARD_PATH . '/config/platform.php'), 'platform'
        );
    }
}
