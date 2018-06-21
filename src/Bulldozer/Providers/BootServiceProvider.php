<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Bulldozer\Http\Composers\SystemMenuComposer;

/**
 * Class BootServiceProvider
 */
class BootServiceProvider extends ServiceProvider
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
        $this->dashboard = $dashboard;

        $this->dashboard
            ->registerEntities(config('press.entities', []))
            ->registerPermissions($this->registerPermissions());

        $this->registerProviders();

        View::composer('platform::container.systems.index', SystemMenuComposer::class);
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
            RouteBootServiceProvider::class,
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissions(): array
    {
        return [
            trans('platform::permission.boot') => [
                [
                    'slug'        => 'platform.boot',
                    'description' => 'Быстрый старт',
                ],
            ],
        ];
    }
}
