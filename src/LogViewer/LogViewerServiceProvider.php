<?php namespace Orchid\LogViewer;

use Illuminate\Support\ServiceProvider;
use Orchid\LogViewer\Providers\UtilitiesServiceProvider;

/**
 * Class     LogViewerServiceProvider
 *
 * @package  Orchid\LogViewer
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LogViewerServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'log-viewer';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        //$this->registerConfig();

        // $this->registerProvider(Providers\UtilitiesServiceProvider::class);
        $this->registerLogViewer();
        //$this->registerAliases();
        //$this->registerConsoleServiceProvider(Providers\CommandsServiceProvider::class);
    }

    /**
     * Register the log data class.
     */
    private function registerLogViewer()
    {
        $this->app->singleton(Contracts\LogViewer::class, LogViewer::class);
        $this->app->singleton('arcanedev.log-viewer', Contracts\LogViewer::class);
        //$this->app->singleton(LogViewer::class);
        $this->app->alias('arcanedev.log-viewer', Facades\LogViewer::class);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        //$this->publishConfig();
        //$this->publishViews();
        //$this->publishTranslations();
        $this->app->register(UtilitiesServiceProvider::class);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Services Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arcanedev.log-viewer',
            Contracts\LogViewer::class,
        ];
    }
}
