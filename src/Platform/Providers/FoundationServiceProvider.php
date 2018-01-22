<?php

namespace Orchid\Platform\Providers;

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Kernel\Dashboard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

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

        $this->registerEloquentFactoriesFrom(realpath(DASHBOARD_PATH.'/database/factories'));

        $this->registerDatabase();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        $this->registerProviders();
    }

    /**
     * Register factories.
     *
     * @param $path
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }

    /**
     * Register migrate.
     */
    protected function registerDatabase()
    {
        $this->loadMigrationsFrom(realpath(DASHBOARD_PATH.'/database/migrations'));
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(realpath(DASHBOARD_PATH.'/resources/lang'), 'dashboard');
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            realpath(DASHBOARD_PATH.'/config/scout.php')    => config_path('scout.php'),
            realpath(DASHBOARD_PATH.'/config/platform.php') => config_path('platform.php'),
            realpath(DASHBOARD_PATH.'/config/widget.php')   => config_path('widget.php'),
        ]);

        $this->mergeConfigFrom(realpath(DASHBOARD_PATH.'/config/platform.php'), 'platform');
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        if (config('platform.headless')) {
            return;
        }

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path.'/vendor/orchid/dashboard';
        }, config('view.paths')), [
            DASHBOARD_PATH.'/resources/views',
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
            AlertServiceProvider::class,
            WidgetServiceProvider::class,
            DashboardProvider::class,
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
        if (! Route::hasMacro('screen')) {
            Route::macro('screen', function ($url, $screen, $name) {
                return Route::any($url.'/{method?}/{argument?}', "$screen@handle")->name($name);
            });
        }

        if (! defined('DASHBOARD_PATH')) {
            define('DASHBOARD_PATH', realpath(__DIR__.'/../../../'));
        }
    }
}
