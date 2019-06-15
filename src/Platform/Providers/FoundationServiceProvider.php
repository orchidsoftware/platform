<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Routing\Router;
use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Watson\Active\ActiveServiceProvider;
use Orchid\Platform\Commands\LinkCommand;
use Orchid\Platform\Commands\RowsCommand;
use Orchid\Platform\Commands\AdminCommand;
use Orchid\Platform\Commands\ChartCommand;
use Orchid\Platform\Commands\TableCommand;
use Orchid\Platform\Commands\FilterCommand;
use Orchid\Platform\Commands\ScreenCommand;
use Orchid\Platform\Commands\InstallCommand;
use Orchid\Platform\Commands\MetricsCommand;
use Orchid\Platform\Commands\SelectionCommand;

/**
 * Class FoundationServiceProvider.
 * After update run:  php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider".
 */
class FoundationServiceProvider extends ServiceProvider
{
    /**
     * The available command shortname.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        LinkCommand::class,
        AdminCommand::class,
        FilterCommand::class,
        RowsCommand::class,
        ScreenCommand::class,
        TableCommand::class,
        ChartCommand::class,
        MetricsCommand::class,
        SelectionCommand::class,
    ];

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this
            ->registerOrchid()
            ->registerDatabase()
            ->registerConfig()
            ->registerTranslations()
            ->registerViews()
            ->registerProviders();
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase(): self
    {
        $path = realpath(PLATFORM_PATH.'/database/migrations');

        $this->loadMigrationsFrom($path);

        $this->publishes([
            $path => database_path('migrations'),
        ], 'migrations');

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
        $path = realpath(PLATFORM_PATH.'/resources/views');

        $this->loadViewsFrom($path, 'platform');

        $this->publishes([
            $path => resource_path('views/vendor/platform'),
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
            ScoutServiceProvider::class,
            ActiveServiceProvider::class,
            RouteServiceProvider::class,
            EventServiceProvider::class,
            PlatformServiceProvider::class,
        ];
    }

    /**
     * Register bindings the service provider.
     */
    public function register(): void
    {
        $this->commands($this->commands);

        $this->app->singleton(Dashboard::class, function () {
            return new Dashboard();
        });

        if (! Route::hasMacro('screen')) {
            Route::macro('screen', function ($url, $screen, $name = null) {
                /* @var Router $this */
                return $this->any($url.'/{method?}/{argument?}', [$screen, 'handle'])
                    ->name($name);
            });
        }

        if (! defined('PLATFORM_PATH')) {
            /*
             * Get the path to the ORCHID Platform folder.
             */
            define('PLATFORM_PATH', realpath(__DIR__.'/../../../'));
        }

        $this->mergeConfigFrom(
            realpath(PLATFORM_PATH.'/config/platform.php'), 'platform'
        );
    }
}
