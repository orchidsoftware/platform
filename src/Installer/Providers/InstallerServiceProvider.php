<?php

namespace Orchid\Installer\Providers;

use App;
use Illuminate\Support\ServiceProvider;

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

        include __DIR__.'/../routes.php';
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        app('router')->pushMiddlewareToGroup('web', '\Orchid\Installer\Middleware\RedirectInstall');
        app('router')->middleware('canInstall', '\Orchid\Installer\Middleware\CanInstall');
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
