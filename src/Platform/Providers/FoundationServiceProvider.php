<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Orchid\Icons\IconServiceProvider;
use Orchid\Platform\Commands\AdminCommand;
use Orchid\Platform\Commands\ChartCommand;
use Orchid\Platform\Commands\FilterCommand;
use Orchid\Platform\Commands\InstallCommand;
use Orchid\Platform\Commands\ListenerCommand;
use Orchid\Platform\Commands\PresenterCommand;
use Orchid\Platform\Commands\PublishCommand;
use Orchid\Platform\Commands\RowsCommand;
use Orchid\Platform\Commands\ScreenCommand;
use Orchid\Platform\Commands\SelectionCommand;
use Orchid\Platform\Commands\TableCommand;
use Orchid\Platform\Commands\TabMenuCommand;
use Orchid\Platform\Components\Notification;
use Orchid\Platform\Dashboard;
use Orchid\Screen\Components\Popover;
use Tabuna\Breadcrumbs\BreadcrumbsServiceProvider;
use Watson\Active\ActiveServiceProvider;

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
        PublishCommand::class,
        AdminCommand::class,
        FilterCommand::class,
        RowsCommand::class,
        ScreenCommand::class,
        TableCommand::class,
        ChartCommand::class,
        SelectionCommand::class,
        ListenerCommand::class,
        PresenterCommand::class,
        TabMenuCommand::class,
    ];

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this
            ->registerOrchid()
            ->registerAssets()
            ->registerDatabase()
            ->registerConfig()
            ->registerTranslations()
            ->registerViews()
            ->registerOctaneEventsListen();
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase(): self
    {
        $this->publishes([
            Dashboard::path('database/migrations') => database_path('migrations'),
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
        $this->loadJsonTranslationsFrom(Dashboard::path('resources/lang/'));

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
            Dashboard::path('config/platform.php') => config_path('platform.php'),
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
            Dashboard::path('stubs/app/routes/') => base_path('routes'),
            Dashboard::path('stubs/app/Orchid/') => app_path('Orchid'),
        ], 'orchid-app-stubs');

        return $this;
    }

    /**
     * Register the asset publishing configuration.
     *
     * @return $this
     */
    protected function registerAssets(): self
    {
        $this->publishes([
            Dashboard::path('public') => public_path('vendor/orchid'),
        ], ['orchid-assets', 'laravel-assets']);

        return $this;
    }

    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViews(): self
    {
        $path = Dashboard::path('resources/views');

        $this->loadViewsFrom($path, 'platform');

        $this->publishes([
            $path => resource_path('views/vendor/platform'),
        ], 'views');

        return $this;
    }

    /**
     * Register provider.
     *
     * @return $this
     */
    public function registerProviders(): self
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }

        return $this;
    }

    /**
     * Flush state when using Laravel Octane
     * https://laravel.com/docs/8.x/octane
     *
     * @return $this
     */
    public function registerOctaneEventsListen(): self
    {
        Event::listen(function (\Laravel\Octane\Events\RequestReceived $request) {
            \Orchid\Support\Facades\Dashboard::flushState();
        });

        return $this;
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
            IconServiceProvider::class,
            BreadcrumbsServiceProvider::class,
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
        $this
            ->registerTranslations()
            ->registerProviders()
            ->commands($this->commands);

        $this->app->singleton(Dashboard::class, static function () {
            return new Dashboard();
        });

        if (! Route::hasMacro('screen')) {
            Route::macro('screen', function ($url, $screen) {
                /* @var Router $this */
                $route = $this->match(['GET', 'HEAD', 'POST'], $url.'/{method?}', [$screen, 'handle']);

                $route->where('method', $screen::getAvailableMethods()->implode('|'));

                return $route;
            });
        }

        $this->mergeConfigFrom(
            Dashboard::path('config/platform.php'), 'platform'
        );

        Blade::component('orchid-popover', Popover::class);
        Blade::component('orchid-notification', Notification::class);
    }
}
