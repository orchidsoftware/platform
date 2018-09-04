<?php

declare(strict_types=1);

namespace App\Orchid\Composers;

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
            ])
            ->add('CMS', [
                'slug'       => 'category',
                'icon'       => 'icon-briefcase',
                'route'      => route('platform.systems.category'),
                'label'      => trans('platform::menu.sections'),
                'permission' => 'platform.systems.category',
                'groupname'  => trans('platform::systems/category.groupname'),
                'sort'       => 10,
            ])
            ->add('CMS', [
                'slug'       => 'comment',
                'icon'       => 'icon-bubbles',
                'route'      => route('platform.systems.comments'),
                'groupname'  => trans('platform::systems/comment.groupname'),
                'label'      => trans('platform::menu.comments'),
                'permission' => 'platform.systems.comments',
                'sort'       => 11,
                'badge'      => [
                    'class' => 'bg-primary',
                    'data'  => function () {
                        $count = Dashboard::model(\Orchid\Press\Models\Comment::class)::where('approved', 0)->count();

                        return $count ?: null;
                    },
                ],
            ]);
    }
}
