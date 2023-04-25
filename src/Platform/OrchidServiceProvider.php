<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/*
 * This class represents the Orchid Service Provider.
 * It is used to register the menus, permissions and search models to the dashboard.
 */
abstract class OrchidServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(Dashboard $dashboard): void
    {
        // Register the menu items
        View::composer('platform::dashboard', function () use ($dashboard) {
            foreach ([...$this->menu(), ...$this->registerMenu(), ...$this->registerMainMenu(), ...$this->registerProfileMenu()] as $element) {
                $dashboard->registerMenuElement(Dashboard::MENU_MAIN, $element);
            }
        });

        // Register the permissions
        foreach ([...$this->permissions(), ...$this->registerPermissions()] as $permission) {
            $dashboard->registerPermissions($permission);
        }

        // Register the search models
        $dashboard->registerSearch($this->registerSearchModels());
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
}
