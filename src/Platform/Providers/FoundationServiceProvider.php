<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Support\Facades\Route;
use Orchid\Alert\AlertServiceProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Orchid\Widget\WidgetServiceProvider;
use Watson\Active\ActiveServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Intervention\Image\ImageServiceProvider;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Laracasts\Generators\GeneratorsServiceProvider;
use Orchid\Attachment\Providers\AttachmentServiceProvider;
use Laravolt\Avatar\ServiceProvider as AvatarServiceProvider;

/**
 * Class FoundationServiceProvider.
 * After update run:  php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider".
 */
class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerEloquentFactoriesFrom()
            ->registerOrchid()
            ->registerDatabase()
            ->registerConfig()
            ->registerTranslations()
            ->registerViews()
            ->registerProviders();
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
        ], 'config');

        return $this;
    }

    /**
     * Register orchid.
     *
     * @return $this
     */
    protected function registerOrchid()
    {
        $this->publishes([
            realpath(PLATFORM_PATH.'/install-stubs/routes') => base_path('routes'),
            realpath(PLATFORM_PATH.'/install-stubs/Orchid') => app_path('Orchid'),
        ]);

        return $this;
    }

    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViews()
    {
        $this->loadViewsFrom(PLATFORM_PATH.'/resources/views', 'platform');

        $this->publishes([
            PLATFORM_PATH.'/resources/views' => resource_path('views/vendor/platform'),
        ], 'views');

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
            DashboardServiceProvider::class,
            ScoutServiceProvider::class,
            ActivitylogServiceProvider::class,
            AttachmentServiceProvider::class,
            GeneratorsServiceProvider::class,
            ActiveServiceProvider::class,
            AvatarServiceProvider::class,
            ImageServiceProvider::class,
            RouteServiceProvider::class,
            AlertServiceProvider::class,
            WidgetServiceProvider::class,
            ConsoleServiceProvider::class,
            EventServiceProvider::class,
            PlatformServiceProvider::class,
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
    }
}
