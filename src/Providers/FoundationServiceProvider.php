<?php

namespace Orchid\Providers;

use Cartalyst\Tags\TagsServiceProvider;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageServiceProvider;
use Orchid\Alert\Laravel\AlertServiceProvider;
use Orchid\Defender\Providers\DefenderServiceProvider;
use Orchid\Kernel\Dashboard;
use Orchid\Log\LogServiceProvider;
use Orchid\Setting\Providers\SettingServiceProvider;
use Orchid\Widget\Providers\WidgetServiceProvider;
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

        $this->registerCode();
        $this->registerDatabase();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerPublic();

        $this->registerProviders();
    }

    /**
     * Register types.
     */
    protected function registerCode()
    {
        $this->publishes([
            DASHBOARD_PATH . '/resources/stubs/behaviors/DemoPost.stub' => app_path('/Core/Behaviors/Many/DemoPost.php'),
            DASHBOARD_PATH . '/resources/stubs/behaviors/DemoPage.stub' => app_path('/Core/Behaviors/Single/DemoPage.php'),

            DASHBOARD_PATH . '/resources/stubs/widgets/AdvertisingWidget.stub' => app_path('/Http/Widgets/AdvertisingWidget.php'),
        ]);
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
            DASHBOARD_PATH . '/resources/stubs/config/content.php' => config_path('content.php'),
        ]);

        $this->mergeConfigFrom(
            DASHBOARD_PATH . '/resources/stubs/config/content.php', 'content'
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
    	
    	$this->publishes([
    		DASHBOARD_PATH . '/resources/views' => resource_path('views/orchid')
	    ]);
    	
	    $this->loadViewsFrom(resource_path('views/orchid'), 'dashboard');
    }

    /**
     * Register public.
     */
    protected function registerPublic()
    {
        $this->publishes([
            DASHBOARD_PATH . '/resources/assets/dist/' => public_path('orchid'),
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
            \Cviebrock\EloquentSluggable\ServiceProvider::class,
            AlertServiceProvider::class,
            SettingServiceProvider::class,
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
