<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\Route;
use Orchid\Alert\AlertServiceProvider;
use Illuminate\Support\ServiceProvider;
use Orchid\Widget\WidgetServiceProvider;
use Watson\Active\ActiveServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Intervention\Image\ImageServiceProvider;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Laracasts\Generators\GeneratorsServiceProvider;
use Orchid\Attachment\Providers\AttachmentServiceProvider;

/**
 * Class FoundationServiceProvider.
 */
class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerTranslations();
    }

    /**
     * Register factories.
     *
     * @return $this
     */
    protected function registerEloquentFactoriesFrom()
    {
        $this->app->make(Factory::class)->load(realpath(PLATFORM_PATH.'/database/factories'));

        return $this;
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase()
    {
        $this->loadMigrationsFrom(realpath(PLATFORM_PATH.'/database/migrations/platform'));

        return $this;
    }

    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(realpath(PLATFORM_PATH.'/resources/lang'), 'platform');

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
            realpath(PLATFORM_PATH.'/config/scout.php')    => config_path('scout.php'),
            realpath(PLATFORM_PATH.'/config/platform.php') => config_path('platform.php'),
            realpath(PLATFORM_PATH.'/config/widget.php')   => config_path('widget.php'),
        ]);

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
            realpath(PLATFORM_PATH.'/resources/stubs/route.stub') => base_path('routes/platform.php'),
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
        $this->loadViewsFrom(PLATFORM_PATH.'/resources/views', 'platform');

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
            ActivitylogServiceProvider::class,
            AttachmentServiceProvider::class,
            GeneratorsServiceProvider::class,
            ActiveServiceProvider::class,
            ImageServiceProvider::class,
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
                return Route::any($url.'/{method?}/{argument?}')
                    ->uses($screen.'@handle')
                    ->name($name);
            });
        }

        if (! defined('PLATFORM_PATH')) {
            /*
             * Get the path to the ORCHID Platform folder.
             */
            define('PLATFORM_PATH', realpath(__DIR__.'/../../../'));
        }

        $this->app->singleton(Dashboard::class, function () {
            return new Dashboard();
        });



            $this->registerEloquentFactoriesFrom()
            ->registerRoute()
            ->registerDatabase()
            ->registerConfig()
            ->registerViews()
            ->registerProviders();
    }
}
