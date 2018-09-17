<?php

declare(strict_types=1);

namespace Orchid\Savior\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Savior\Http\Composers\SystemMenuComposer;

class SaviorServiceProvider extends ServiceProvider
{
    /**
     * @var Dashboard
     */
    protected $dashboard;

    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard
            ->registerPermissions($this->registerPermissions());

        View::composer('platform::container.systems.index', SystemMenuComposer::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerProviders();
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase()
    {
        $this->loadMigrationsFrom(realpath(PLATFORM_PATH.'/database/migrations/savior'));

        return $this;
    }

    /**
     * Register config.
     *
     * @return $this
     */
    protected function registerConfig()
    {
        $this->publishes([
            realpath(PLATFORM_PATH.'/config/savior.php') => config_path('savior.php'),
        ]);

        return $this;
    }

    /**
     * Register provider.
     */
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
            ConsoleServiceProvider::class,
            RoutePressServiceProvider::class,
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissions(): array
    {
        return [
            trans('platform::permission.main.systems') => [
                [
                    'slug'        => 'platform.savior.backups',
                    'description' => trans('platform.savior.backups'),
                ],
                [
                    'slug'        => 'platform.savior.announcement',
                    'description' => trans('platform.savior.announcement'),
                ],
            ],
        ];
    }
}
