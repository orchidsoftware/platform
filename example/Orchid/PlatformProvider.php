<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class PlatformProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        View::composer('platform::layouts.dashboard', function () {
        });

        View::composer('platform::container.systems.index', $this->registerMenu($dashboard));

        $dashboard
            ->registerPermissions($this->registerPermissionsMain())
            ->registerPermissions($this->registerPermissionsSystems());
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain(): array
    {
        return [
            trans('platform::permission.main.main') => [
                [
                    'slug'        => 'platform.index',
                    'description' => trans('platform::permission.main.main'),
                ],
                [
                    'slug'        => 'platform.systems',
                    'description' => trans('platform::permission.main.systems'),
                ],
                [
                    'slug'        => 'platform.systems.index',
                    'description' => trans('platform::permission.systems.settings'),
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
            trans('platform::permission.main.systems') => [
                [
                    'slug'        => 'platform.systems.roles',
                    'description' => trans('platform::permission.systems.roles'),
                ],
                [
                    'slug'        => 'platform.systems.users',
                    'description' => trans('platform::permission.systems.users'),
                ],
                [
                    'slug'        => 'platform.systems.attachment',
                    'description' => trans('platform::permission.systems.attachment'),
                ],
                [
                    'slug'        => 'platform.systems.media',
                    'description' => trans('platform::permission.systems.media'),
                ],
                [
                    'slug'        => 'platform.systems.cache',
                    'description' => trans('platform::permission.systems.cache'),
                ],
            ],
        ];
    }

    /**
     * @param \Orchid\Platform\Dashboard $dashboard
     */
    protected function registerMenu(Dashboard $dashboard)
    {
        $dashboard->menu
            ->add('Systems', [
                'slug'       => 'Auth',
                'icon'       => 'icon-lock',
                'label'      => trans('platform::systems/settings.system_menu.Sharing access rights'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems',
                'sort'       => 1000,
            ])
            ->add('Auth', [
                'slug'       => 'users',
                'icon'       => 'icon-user',
                'route'      => route('platform.systems.users'),
                'label'      => trans('platform::menu.users'),
                'groupname'  => trans('platform::systems/users.groupname'),
                'permission' => 'platform.systems.users',
                'sort'       => 9,
            ])
            ->add('Auth', [
                'slug'       => 'roles',
                'icon'       => 'icon-lock',
                'route'      => route('platform.systems.roles'),
                'label'      => trans('platform::menu.roles'),
                'groupname'  => trans('platform::systems/roles.groupname'),
                'permission' => 'platform.systems.roles',
                'sort'       => 10,
            ]);
    }
}
