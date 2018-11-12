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
                ItemMenu::setLabel(__('Access rights'))
                    ->setIcon('icon-lock')
                    ->setSlug('Auth')
                    ->setActive('platform.systems.*')
                    ->setPermission('platform.systems')
                    ->setSort(1000)
            )
            ->add('Auth',
                ItemMenu::setLabel(__('Users'))
                    ->setIcon('icon-user')
                    ->setRoute(route('platform.systems.users'))
                    ->setPermission('platform.systems.users')
                    ->setSort(1000)
                    ->setGroupName(__('All registered users'))
            )
            ->add('Auth',
                ItemMenu::setLabel(__('Roles'))
                    ->setIcon('icon-lock')
                    ->setRoute(route('platform.systems.roles'))
                    ->setPermission('platform.systems.roles')
                    ->setSort(1000)
                    ->setGroupName(__('A Role defines a set of tasks a user assigned the role is allowed to perform. '))
            )
            ->add('CMS',
                ItemMenu::setLabel(__('Categories'))
                    ->setIcon('icon-briefcase')
                    ->setRoute(route('platform.systems.category'))
                    ->setPermission('platform.systems.category')
                    ->setSort(1000)
                    ->setGroupName(__('Sort entries into groups of posts on a given topic. This helps the user to find the necessary information on the site.'))
            )
            ->add('CMS',
                ItemMenu::setLabel(__('Comments'))
                    ->setIcon('icon-bubbles')
                    ->setRoute(route('platform.systems.comments'))
                    ->setPermission('platform.systems.comments')
                    ->setSort(1000)
                    ->setGroupName(__("Comments allow your website's visitors to have a discussion with you and each other."))
                    ->setBadge(function () {
                        return \Orchid\Press\Models\Comment::where('approved', 0)->count() ?: null;
                    })
            );
    }
}
