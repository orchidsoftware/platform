<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

abstract class OrchidServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(Dashboard $dashboard): void
    {
        View::composer('platform::dashboard', function () use ($dashboard) {
            foreach ([...$this->menu(), ...$this->registerMenu(), ...$this->registerMainMenu(), ...$this->registerProfileMenu()] as $element) {
                $dashboard->registerMenuElement(Dashboard::MENU_MAIN, $element);
            }
        });

        foreach ([...$this->permissions(), ...$this->registerPermissions()] as $permission) {
            $dashboard->registerPermissions($permission);
        }

        $dashboard->registerSearch($this->registerSearchModels());
    }

    /**
     * @return \Orchid\Screen\Actions\Menu[]
     */
    public function menu(): array
    {
        return [];
    }

    /**
     * @deprecated Usage method `menu`
     *
     * @return \Orchid\Screen\Actions\Menu[]
     */
    public function registerMenu(): array
    {
        return [];
    }

    /**
     * @deprecated Usage method `menu`
     *
     * @return \Orchid\Screen\Actions\Menu[]
     */
    public function registerMainMenu(): array
    {
        return [];
    }

    /**
     * @deprecated Usage method `menu`
     *
     * @return \Orchid\Screen\Actions\Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [];
    }

    /**
     * @deprecated Usage method `permissions`
     *
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [];
    }

    /**
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [];
    }

    /**
     * @deprecated Use config to define
     *
     * @return string[]
     */
    public function registerSearchModels(): array
    {
        return [];
    }
}
