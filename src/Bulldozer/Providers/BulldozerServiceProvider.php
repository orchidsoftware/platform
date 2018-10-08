<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Bulldozer\Http\Composers\SystemMenuComposer;

/**
 * Class BulldozerServiceProvider.
 */
class BulldozerServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard
            ->registerEntities(config('press.entities', []))
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
            RouteBulldozerServiceProvider::class,
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
                    'slug'        => 'platform.bulldozer',
                    'description' => 'Быстрый старт',
                ],
            ],
        ];
    }
}
