<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageServiceProvider;
use Laracasts\Generators\GeneratorsServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Laravolt\Avatar\ServiceProvider as AvatarServiceProvider;
use Orchid\Alert\AlertServiceProvider;
use Orchid\Attachment\Providers\AttachmentServiceProvider;
use Orchid\Widget\WidgetServiceProvider;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Watson\Active\ActiveServiceProvider;

/**
 * Class FoundationServiceProvider.
 * After update run:  php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider".
 */
class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
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
    protected function registerEloquentFactoriesFrom(): self
    {
        $this->app->make(Factory::class)->load(realpath(PLATFORM_PATH.'/database/factories'));

        return $this;
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase(): self
    {
        $this->loadMigrationsFrom(realpath(PLATFORM_PATH.'/database/migrations/platform'));

        return $this;
    }

    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations(): self
    {
        $this->loadJsonTranslationsFrom(realpath(PLATFORM_PATH.'/resources/lang/'));

        return $this;
    }

    /**
     * Register config.
     *
     * @return $this
     */
    protected function registerConfig(): self
    {
        $this->publishes([
            realpath(PLATFORM_PATH.'/config/platform.php') => config_path('platform.php'),
            realpath(PLATFORM_PATH.'/config/widget.php') => config_path('widget.php'),
        ], 'config');

        return $this;
    }

    /**
     * Register orchid.
     *
     * @return $this
     */
    protected function registerOrchid(): self
    {
        $this->publishes([
            realpath(PLATFORM_PATH.'/install-stubs/routes/') => base_path('routes'),
            realpath(PLATFORM_PATH.'/install-stubs/Orchid/') => app_path('Orchid'),
        ], 'orchid-stubs');

        return $this;
    }

    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViews(): self
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
    public function registerProviders(): void
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
    public function provides(): array
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
    public function register(): void
    {
        if (! Route::hasMacro('screen')) {
            Route::macro('screen', function ($url, $screen, $name = null) {
                return Route::any($url . '/{method?}/{argument?}', [$screen, 'handle'])
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
