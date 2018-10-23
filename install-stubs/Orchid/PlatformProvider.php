<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Orchid\Composers\MainMenuComposer;
use App\Orchid\Composers\SystemMenuComposer;

class PlatformProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        View::composer('platform::layouts.dashboard', MainMenuComposer::class);
        View::composer('platform::container.systems.index', SystemMenuComposer::class);

        $dashboard
            //->registerPermissions($this->registerPermissionsMain())
            ->registerPermissions($this->registerPermissionsSystems());

        $dashboard->registerGlobalSearch([
          //...Models
        ]);
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain(): array
    {
        return [
            __('Main') => [
                [
                    'slug'        => 'platform.index',
                    'description' => __('Main'),
                ],
                [
                    'slug'        => 'platform.systems',
                    'description' => __('Systems'),
                ],
                [
                    'slug'        => 'platform.systems.index',
                    'description' => __('Settings'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsSystems(): array
    {
        return [
            __('Systems') => [
                [
                    'slug'        => 'platform.systems.roles',
                    'description' => __('Roles'),
                ],
                [
                    'slug'        => 'platform.systems.users',
                    'description' => __('Users'),
                ],
                [
                    'slug'        => 'platform.systems.comments',
                    'description' => __('Comments'),
                ],
                [
                    'slug'        => 'platform.systems.category',
                    'description' => __('Category'),
                ],
            ],
        ];
    }
}
