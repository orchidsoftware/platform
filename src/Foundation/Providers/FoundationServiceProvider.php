<?php

namespace Orchid\Foundation\Providers;

use Cartalyst\Tags\TagsServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Orchid\Alert\AlertServiceProvider;
use Orchid\Defender\Providers\DefenderServiceProvider;
use Orchid\Foundation\Kernel\Dashboard;
use Orchid\Foundation\Macros\Page;
use Orchid\Installer\Providers\InstallerServiceProvider;
use Orchid\Log\LogServiceProvider;
use Orchid\Search\Elasticsearch\ElasticsearchServiceProvicer;
use Orchid\Settings\Providers\SettingsServiceProvider;
use Orchid\Widget\Providers\WidgetServiceProvider;
use Spatie\Backup\BackupServiceProvider;
use Watson\Active\ActiveServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $routeMacros = [
        Page::class,
    ];

    /**
     * Boot the application events.
     *
     * @param Router $router
     */
    public function boot(Router $router)
    {
        $this->app->singleton(Dashboard::class, function ($app) {
            return new Dashboard();
        });

        $this->registerDatabase();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerPublic();

        $this->macrosRegister($router);
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
            __DIR__.'/../Config/ads.php' => config_path('ads.php'),
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
        }, config('view.paths')), [$sourcePath]), 'dashboard');
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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            InstallerServiceProvider::class,
            AlertServiceProvider::class,
            SettingsServiceProvider::class,
            WidgetServiceProvider::class,
            RouteServiceProvider::class,
            ConsoleServiceProvider::class,
            PermissionServiceProvider::class,
            EventServiceProvider::class,
            ActiveServiceProvider::class,
            ImageServiceProvider::class,
            TagsServiceProvider::class,
            BackupServiceProvider::class,
            LogServiceProvider::class,
            ScoutServiceProvider::class,
            ElasticsearchServiceProvicer::class,
            DefenderServiceProvider::class,
            MenuServiceProvider::class,
        ];
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * @param Router $route
     */
    public function macrosRegister(Router $route)
    {
        foreach ($this->routeMacros as $macro) {
            (new $macro())->register($route);
        }
    }
}
