<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Icons\IconFinder;
use Orchid\Screen\Actions\Menu;

/*
 * This class represents the Orchid Service Provider.
 * It is used to register the menus, permissions and search models to the dashboard.
 */
abstract class OrchidServiceProvider extends ServiceProvider
{
    /**
     * The Orchid Dashboard instance.
     *
     * @var Orchid|null
     */
    protected ?Orchid $orchid;

    /**
     * Boot the application events.
     */
    public function boot(Orchid $orchid): void
    {
        // Need for backward compatibility
        $this->orchid = $orchid;

        $this
            ->definePermissions()
            ->defineRoutes()
            ->defineSearch()
            ->defineIcons()
            ->defineMenu()
            ->defineResources();
    }

    /**
     * Get the Orchid Dashboard instance.
     *
     * @return Orchid
     */
    private function orchidSingleton(): Orchid
    {
        if ($this->orchid === null) {
            $this->orchid = $this->app->make(Orchid::class);
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
        View::composer('orchid::dashboard', function () {
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

        Route::domain((string) config('orchid.domain'))
            ->prefix(Orchid::prefix('/'))
            ->middleware(config('orchid.middleware.private'))
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
     * @return Menu[]
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
     * @return Menu[]
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
     * @return Menu[]
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
     * @return Menu[]
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
     * @param Router $router
     *
     * @return void
     */
    public function routes(Router $router): void
    {
        // Define routes.
    }

    /**
     * Define the stylesheets to be registered.
     *
     * @return string[]
     */
    public function stylesheets(): array
    {
        return [];
    }

    /**
     * Define the scripts to be registered.
     *
     * @return string[]
     */
    public function scripts(): array
    {
        return [];
    }

    /**
     * Define the resources to be registered.
     *
     * @return void
     */
    protected function defineResources(): void
    {
        foreach ($this->stylesheets() as $stylesheet) {
            $this->orchid->registerResource('stylesheets', $stylesheet);
        }

        foreach ($this->scripts() as $script) {
            $this->orchid->registerResource('scripts', $script);
        }
    }
}
