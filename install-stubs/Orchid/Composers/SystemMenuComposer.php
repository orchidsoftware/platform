<?php

declare(strict_types=1);

namespace App\Orchid\Composers;

use Orchid\Platform\Menu;
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
            ->add(Menu::SYSTEMS,
                ItemMenu::label(__('Access rights'))
                    ->icon('icon-lock')
                    ->slug('Auth')
                    ->active('platform.systems.*')
                    ->permission('platform.systems')
                    ->sort(1000)
            )
            ->add('Auth',
                ItemMenu::label(__('Users'))
                    ->icon('icon-user')
                    ->route('platform.systems.users')
                    ->permission('platform.systems.users')
                    ->sort(1000)
                    ->groupName(__('All registered users'))
            )
            ->add('Auth',
                ItemMenu::label(__('Roles'))
                    ->icon('icon-lock')
                    ->route('platform.systems.roles')
                    ->permission('platform.systems.roles')
                    ->sort(1000)
                    ->groupName(__('A Role defines a set of tasks a user assigned the role is allowed to perform. '))
            )
            ->add('CMS',
                ItemMenu::label(__('Categories'))
                    ->icon('icon-briefcase')
                    ->route('platform.systems.category')
                    ->permission('platform.systems.category')
                    ->sort(1000)
                    ->groupName(__('Sort entries into groups of posts on a given topic. This helps the user to find the necessary information on the site.'))
            )
            ->add('CMS',
                ItemMenu::label(__('Comments'))
                    ->icon('icon-bubbles')
                    ->route('platform.systems.comments')
                    ->permission('platform.systems.comments')
                    ->sort(1000)
                    ->groupName(__("Comments allow your website's visitors to have a discussion with you and each other."))
                    ->badge(function () {
                        return \Orchid\Press\Models\Comment::where('approved', 0)->count() ?: null;
                    })
            );
    }
}
