<?php

namespace Orchid\Platform\Providers;

use Cartalyst\Tags\TagsServiceProvider;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageServiceProvider;
use Orchid\Alert\Laravel\AlertServiceProvider;
use Orchid\Defender\Providers\DefenderServiceProvider;
use Orchid\Platform\Kernel\Dashboard;
use Orchid\Log\LogServiceProvider;
use Orchid\Setting\Providers\SettingServiceProvider;
use Orchid\Platform\Widget\Providers\WidgetServiceProvider;
use Spatie\Backup\BackupServiceProvider;
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
        $this->registerPublic();

        $this->registerProviders();
    }


    /**
     * Register migrate.
     */
    protected function registerDatabase()
    {
        $this->publishes([
            DASHBOARD_PATH . '/resources/stubs/database/migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(DASHBOARD_PATH . '/resources/lang', 'dashboard');
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            DASHBOARD_PATH . '/config/content.php' => config_path('content.php'),
        ]);

        $this->mergeConfigFrom(
            DASHBOARD_PATH . '/config/content.php', 'content'
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/vendor/orchid/dashboard';
        }, config('view.paths')), [
            DASHBOARD_PATH . '/resources/views',
        ]), 'dashboard');
    }

    /**
     * Register public.
     */
    protected function registerPublic()
    {
        $this->publishes([
            DASHBOARD_PATH . '/public/' => public_path('orchid'),
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
            AlertServiceProvider::class,
            RouteServiceProvider::class,
            ConsoleServiceProvider::class,
            PermissionServiceProvider::class,
            EventServiceProvider::class,
            ActiveServiceProvider::class,
            DefenderServiceProvider::class,
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
}
