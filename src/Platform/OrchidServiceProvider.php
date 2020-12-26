<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

abstract class OrchidServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        View::composer('platform::dashboard', function () use ($dashboard) {
            foreach ($this->registerMainMenu() as $itemMenu) {
                $dashboard->menu->add(Menu::MAIN, $itemMenu);
            }
        });

        View::composer('platform::partials.profile', function () use ($dashboard) {
            foreach ($this->registerProfileMenu() as $itemMenu) {
                $dashboard->menu->add(Menu::PROFILE, $itemMenu);
            }
        });

        View::composer('platform::systems', function () use ($dashboard) {
            foreach ($this->registerSystemMenu() as $itemMenu) {
                $dashboard->menu->add(Menu::SYSTEMS, $itemMenu);
            }
        });

        foreach ($this->registerPermissions() as $permission) {
            $dashboard->registerPermissions($permission);
        }

        $dashboard->registerSearch($this->registerSearchModels());
    }

    /**
     * @return ItemMenu[]
     */
    public function registerMainMenu(): array
    {
        return [];
    }

    /**
     * @return ItemMenu[]
     */
    public function registerProfileMenu(): array
    {
        return [];
    }

    /**
     * @return ItemMenu[]
     */
    public function registerSystemMenu(): array
    {
        return [];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function registerSearchModels(): array
    {
        return [];
    }
}
