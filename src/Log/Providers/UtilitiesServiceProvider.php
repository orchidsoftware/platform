<?php

namespace Orchid\Log\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Log\Contracts;
use Orchid\Log\Utilities;

class UtilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerLogLevels();
        $this->registerStyler();
        $this->registerLogMenu();
        $this->registerFilesystem();
        $this->registerFactory();
        $this->registerChecker();
    }

    /**
     * Register the log levels.
     */
    private function registerLogLevels()
    {
        $this->app->singleton(Contracts\Utilities\LogLevels::class, function ($app) {
            /**
             * @var \Illuminate\Config\Repository
             * @var \Illuminate\Translation\Translator $translator
             */
            $translator = $app['translator'];

            return new Utilities\LogLevels($translator, 'en');
        });

        $this->app->singleton('arcanedev.log-viewer.levels', Contracts\Utilities\LogLevels::class);
    }

    /**
     * Register the log styler.
     */
    private function registerStyler()
    {
        $this->app->singleton(Contracts\Utilities\LogStyler::class, Utilities\LogStyler::class);
        $this->app->singleton('arcanedev.log-viewer.styler', Contracts\Utilities\LogStyler::class);
    }

    /**
     * Register the log menu builder.
     */
    private function registerLogMenu()
    {
        $this->app->singleton(Contracts\Utilities\LogMenu::class, Utilities\LogMenu::class);
        $this->app->singleton('arcanedev.log-viewer.menu', Contracts\Utilities\LogMenu::class);
    }

    /**
     * Register the log filesystem.
     */
    private function registerFilesystem()
    {
        $this->app->singleton(Contracts\Utilities\Filesystem::class, function ($app) {
            /**
             * @var \Illuminate\Config\Repository
             * @var \Illuminate\Filesystem\Filesystem $files
             */
            $files = $app['files'];
            $filesystem = new Utilities\Filesystem($files, storage_path('logs'));

            $filesystem->setPattern(
                Utilities\Filesystem::PATTERN_PREFIX,
                Utilities\Filesystem::PATTERN_DATE,
                Utilities\Filesystem::PATTERN_EXTENSION
            );

            return $filesystem;
        });

        $this->app->singleton('arcanedev.log-viewer.filesystem', Contracts\Utilities\Filesystem::class);
    }

    /**
     * Register the log factory class.
     */
    private function registerFactory()
    {
        $this->app->singleton(Contracts\Utilities\Factory::class, Utilities\Factory::class);
        $this->app->singleton('arcanedev.log-viewer.factory', Contracts\Utilities\Factory::class);
    }

    /**
     * Register the log checker service.
     */
    private function registerChecker()
    {
        $this->app->singleton(Contracts\Utilities\LogChecker::class, Utilities\LogChecker::class);
        $this->app->singleton('arcanedev.log-viewer.checker', Contracts\Utilities\LogChecker::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arcanedev.log-viewer.levels',
            Contracts\Utilities\LogLevels::class,
            'arcanedev.log-viewer.styler',
            Contracts\Utilities\LogStyler::class,
            'arcanedev.log-viewer.menu',
            Contracts\Utilities\LogMenu::class,
            'arcanedev.log-viewer.filesystem',
            Contracts\Utilities\Filesystem::class,
            'arcanedev.log-viewer.factory',
            Contracts\Utilities\Factory::class,
            'arcanedev.log-viewer.checker',
            Contracts\Utilities\LogChecker::class,
        ];
    }
}
