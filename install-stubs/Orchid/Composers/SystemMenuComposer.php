<?php

declare(strict_types=1);

namespace App\Orchid\Composers;

use Orchid\Platform\ItemMenu;
use Orchid\Platform\Dashboard;

class SystemMenuComposer
{
    /**
     * @var Dashboard
     */
    private $dashboard;

    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Registering the main menu items.
     */
    public function compose()
    {
        $this->dashboard->menu
            ->add('Systems',
                ItemMenu::setLabel(trans('platform::systems/settings.system_menu.Sharing access rights'))
                    ->setIcon('icon-lock')
                    ->setSlug('Auth')
                    ->setActive('platform.systems.*')
                    ->setPermission('platform.systems')
                    ->setSort(1000)
            )
            ->add('Auth',
                ItemMenu::setLabel(trans('platform::menu.users'))
                    ->setIcon('icon-user')
                    ->setRoute(route('platform.systems.users'))
                    ->setPermission('platform.systems.users')
                    ->setSort(1000)
                    ->setGroupName(trans('platform::systems/users.groupname'))
            )
            ->add('Auth',
                ItemMenu::setLabel(trans('platform::menu.roles'))
                    ->setIcon('icon-lock')
                    ->setRoute(route('platform.systems.roles'))
                    ->setPermission('platform.systems.roles')
                    ->setSort(1000)
                    ->setGroupName(trans('platform::systems/roles.groupname'))
            )
            ->add('CMS',
                ItemMenu::setLabel(trans('platform::menu.sections'))
                    ->setIcon('icon-briefcase')
                    ->setRoute(route('platform.systems.category'))
                    ->setPermission('platform.systems.category')
                    ->setSort(1000)
                    ->setGroupName(trans('platform::systems/category.groupname'))
            )
            ->add('CMS',
                ItemMenu::setLabel(trans('platform::menu.comments'))
                    ->setIcon('icon-bubbles')
                    ->setRoute(route('platform.systems.comments'))
                    ->setPermission('platform.systems.comments')
                    ->setSort(1000)
                    ->setGroupName(trans('platform::systems/comment.groupname'))
                    ->setBadge(function () {
                        return \Orchid\Press\Models\Comment::where('approved', 0)->count() ?: null;
                    })
            );
    }
}
