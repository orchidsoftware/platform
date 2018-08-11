<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Press\Models\Comment;

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
                'slug'       => 'CMS',
                'icon'       => 'icon-layers',
                'label'      => trans('platform::systems/settings.system_menu.Content management'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems',
                'sort'       => 1000,
            ])
            ->add('CMS', [
                'slug'       => 'menu',
                'icon'       => 'icon-menu',
                'route'      => route('platform.systems.menu.index'),
                'label'      => trans('platform::menu.menu'),
                'groupname'  => trans('platform::systems/menu.groupname'),
                'childs'     => false,
                'divider'    => false,
                'permission' => 'platform.systems.menu',
                'sort'       => 1,
                'show'       => count(config('press.menu', [])) > 0,
            ])
            ->add('CMS', [
                'slug'       => 'section',
                'icon'       => 'icon-briefcase',
                'route'      => route('platform.systems.category'),
                'label'      => trans('platform::menu.sections'),
                'permission' => 'platform.systems.category',
                'groupname'  => trans('platform::systems/category.groupname'),
                'sort'       => 2,
            ])
            ->add('CMS', [
                'slug'       => 'comment',
                'icon'       => 'icon-bubbles',
                'route'      => route('platform.systems.comment'),
                'groupname'  => trans('platform::systems/comment.groupname'),
                'label'      => trans('platform::menu.comments'),
                'permission' => 'platform.systems.comment',
                'sort'       => 4,
                'badge'      => [
                    'class' => 'bg-primary',
                    'data'  => function () {
                        $count = Dashboard::model(Comment::class)::where('approved', 0)->count();

                        return $count ? $count : null;
                    },
                ],
            ])
            ->add('CMS', [
                'slug'       => 'media',
                'icon'       => 'icon-folder-alt',
                'route'      => route('platform.systems.media.index'),
                'groupname'  => trans('platform::systems/media.groupname'),
                'label'      => trans('platform::menu.media'),
                'permission' => 'platform.systems.media',
                'sort'       => 5,
            ]);
    }
}
