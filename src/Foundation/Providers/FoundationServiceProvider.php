<?php

namespace Orchid\Foundation\Providers;

use View;
use Illuminate\Routing\Router;
use Cartalyst\Tags\TagsServiceProvider;
use Illuminate\Support\ServiceProvider;
use Orchid\Foundation\Kernel\Dashboard;
use Watson\Active\ActiveServiceProvider;
use Intervention\Image\ImageServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     */
    public function boot(Router $router)
    {
        $this->registerDatabase();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerPublic();

        $this->registerProviders();
    }

    /**
     * Register migrate.
     */
    protected function registerDatabase()
    {
        $this->publishes([
            __DIR__.'/../Database/Migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'dashboard');
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/content.php' => config_path('content.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/content.php', 'content'
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/vendor/orchid/dashboard');
        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path.'/vendor/orchid/dashboard';
        }, \Config::get('view.paths')), [$sourcePath]), 'dashboard');
    }

    protected function registerPublic()
    {
        $this->publishes([
            __DIR__.'/../Resources/dist/' => public_path('orchid'),
        ], 'public');
    }

    public function registerProviders()
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(Dashboard::class, function ($app) {
            return new Dashboard();
        });
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
            MenuServiceProvider::class,
            PermissionServiceProvider::class,
            EventServiceProvider::class,
            ActiveServiceProvider::class,
            ImageServiceProvider::class,
            TagsServiceProvider::class,
        ];
    }
}
