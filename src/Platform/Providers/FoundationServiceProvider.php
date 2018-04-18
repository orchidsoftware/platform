<?php

declare(strict_types=1);

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

        $this->registerEloquentFactoriesFrom(realpath(DASHBOARD_PATH.'/database/factories'))
            ->registerRoute()
            ->registerDatabase()
            ->registerTranslations()
            ->registerConfig()
            ->registerViews()
            ->registerProviders();
    }

    /**
     * Register factories.
     *
     * @param $path
     *
     * @return $this
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);

        return $this;
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase()
    {
        $this->loadMigrationsFrom(realpath(DASHBOARD_PATH.'/database/migrations'));

        return $this;
    }

    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(realpath(DASHBOARD_PATH.'/resources/lang'), 'dashboard');

        return $this;
    }

    /**
     * Register config.
     *
     * @return $this
     */
    protected function registerConfig()
    {
        $this->publishes([
            realpath(DASHBOARD_PATH.'/config/scout.php')    => config_path('scout.php'),
            realpath(DASHBOARD_PATH.'/config/platform.php') => config_path('platform.php'),
            realpath(DASHBOARD_PATH.'/config/widget.php')   => config_path('widget.php'),
        ]);

        $this->mergeConfigFrom(realpath(DASHBOARD_PATH.'/config/platform.php'), 'platform');

        return $this;
    }

    /**
     * Register route.
     *
     * @return $this
     */
    protected function registerRoute()
    {
        $this->publishes([
            realpath(DASHBOARD_PATH.'/resources/stubs/route.stub') => base_path('routes/dashboard.php'),
        ]);

        return $this;
    }

    /**
     * Register views.
     *
     * @return $this
     */
    public function registerViews()
    {
        if (config('platform.headless')) {
            return $this;
        }

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path.'/vendor/orchid/dashboard';
        }, config('view.paths')), [
            DASHBOARD_PATH.'/resources/views',
        ]), 'dashboard');

        return $this;
    }

    /**
     * Register provider.
     */
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
            EventServiceProvider::class,
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
