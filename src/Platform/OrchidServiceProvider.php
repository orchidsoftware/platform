<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Icons\IconFinder;

/*
 * This class represents the Orchid Service Provider.
 * It is used to register the menus, permissions and search models to the dashboard.
 */
abstract class OrchidServiceProvider extends ServiceProvider
{
    /**
     * The Orchid Dashboard instance.
     *
     * @var \Orchid\Platform\Dashboard|null
     */
    protected ?Dashboard $orchid;

    /**
     * Boot the application events.
     */
    public function boot(Dashboard $dashboard): void
    {
        // Need for backward compatibility
        $this->orchid = $dashboard;

        $this
            ->definePermissions()
            ->defineRoutes()
            ->defineSearch()
            ->defineIcons()
            ->defineMenu();
    }

    /**
     * Get the Orchid Dashboard instance.
     *
     * @return \Orchid\Platform\Dashboard
     */
    private function orchidSingleton(): Dashboard
    {
        if ($this->orchid === null) {
            $this->orchid = $this->app->make(Dashboard::class);
        }

        return $this->orchid;
    }

    /**
     * Define search functionality for the dashboard.
     *
     * @return $this
     */
    private function defineSearch(): static
    {
        $this->orchidSingleton()->registerSearch($this->registerSearchModels());

        return $this;
    }

    /**
     * Define menu items for the dashboard.
     *
     * @return $this
     */
    private function defineMenu(): static
    {
        // Register the menu items
        View::composer('platform::dashboard', function () {
            $elements = [...$this->menu(), ...$this->registerMenu(), ...$this->registerMainMenu(), ...$this->registerProfileMenu()];

            foreach ($elements as $element) {
                $this->orchidSingleton()->registerMenuElement($element);
            }
        });

        return $this;
    }

    /**
     * Define permissions for the dashboard.
     *
     * @return $this
     */
    private function definePermissions(): static
    {
        $permissions = [...$this->permissions(), ...$this->registerPermissions()];

        // Register the permissions
        foreach ($permissions as $permission) {
            $this->orchidSingleton()->registerPermissions($permission);
        }

        return $this;
    }

    /**
     * Define routes for the dashboard.
     *
     * @return $this
     */
    private function defineRoutes(): static
    {
        if ($this->app instanceof CachesRoutes && $this->app->routesAreCached()) {
            return $this;
        }

        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->middleware(config('platform.middleware.private'))
            ->group(function (Router $route) {
                $this->routes($route);
            });

        return $this;
    }

    /**
     * Define icon registration for the dashboard.
     *
     * @return $this
     */
    private function defineIcons(): static
    {
        $iconFinder = $this->app->make(IconFinder::class);

        collect($this->icons())->each(fn ($path, $prefix) => $iconFinder->registerIconDirectory($prefix, $path));

        return $this;
    }

    /**
     * Get the icon paths and prefixes.
     *
     * @return array
     */
    public function icons(): array
    {
        return [];
    }

    /**
     * Returns an array of menu items.
     *
     * @return \Orchid\Screen\Actions\Menu[]
     */
    public function menu(): array
    {
        return [];
    }

    /**
     * @deprecated Use the `menu` method instead
     *
     * Returns an array of menu items.
     *
     * @return \Orchid\Screen\Actions\Menu[]
     */
    public function registerMenu(): array
    {
        return [];
    }

    /**
     * @deprecated Use the `menu` method instead
     *
     * Returns an array of menu items.
     *
     * @return \Orchid\Screen\Actions\Menu[]
     */
    public function registerMainMenu(): array
    {
        return [];
    }

    /**
     * @deprecated Use the `menu` method instead
     *
     * Returns an array of menu items.
     *
     * @return \Orchid\Screen\Actions\Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [];
    }

    /**
     * @deprecated Use config instead
     *
     * Returns an array of permissions.
     *
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [];
    }

    /**
     * Returns an array of permissions.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [];
    }

    /**
     * @deprecated Use config instead
     *
     * Returns an array of search models.
     *
     * @return string[]
     */
    public function registerSearchModels(): array
    {
        return [];
    }

    /**
     * Define routes setup.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function routes(Router $router): void
    {
        // Define routes.
    }
}
