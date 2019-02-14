<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
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
     * @return ItemPermission
     */
    protected function registerPermissionsMain(): ItemPermission
    {
        return ItemPermission::setGroup(__('Main'))
            ->addPermission('platform.index', __('Main'))
            ->addPermission('platform.systems', __('Systems'))
            ->addPermission('platform.systems.index', __('Settings'));
    }

    /**
     * @return ItemPermission
     */
    protected function registerPermissionsSystems(): ItemPermission
    {
        return ItemPermission::setGroup(__('Systems'))
            ->addPermission('platform.systems.roles', __('Roles'))
            ->addPermission('platform.systems.users', __('Users'))
            ->addPermission('platform.systems.comments', __('Comments'))
            ->addPermission('platform.systems.category', __('Category'));
    }
}
