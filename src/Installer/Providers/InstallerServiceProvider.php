<?php

namespace Orchid\Installer\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Orchid\Installer\Middleware\CanInstall;
use Orchid\Installer\Middleware\RedirectInstall;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();

        $this->loadRoutesFrom(__DIR__.'/../routes.php');

    }

    /**
     * Bootstrap the application events.
     *
     * @param Router $router
     */
    public function boot(Router $router)
    {
        $router->pushMiddlewareToGroup('web', RedirectInstall::class);
        $router->middlewareGroup('install', [
            CanInstall::class,
        ]);
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__.'/../Views' => base_path('resources/views/vendor/orchid/install'),
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path.'/vendor/orchid/install';
        }, \Config::get('view.paths')), [__DIR__.'/../Views']), 'install');

        $this->publishes([
            __DIR__.'/../Lang' => base_path('resources/lang'),
        ]);
    }
}
