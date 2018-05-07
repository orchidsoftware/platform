<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Press\Behaviors\Single;

class PressMenuComposer
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
        $this
            ->registerMenuSystems($this->dashboard)
            ->registerMenuPost($this->dashboard);
    }

    /**
     * @param Dashboard $kernel
     *
     * @return $this
     */
    protected function registerMenuPost(Dashboard $kernel): self
    {
        $allPost = $this->dashboard->getBehaviors()
            ->where('display', true)
            ->all();

        $kernel->menu->add('Main', [
            'slug'       => 'Posts',
            'icon'       => 'icon-notebook',
            'route'      => '#',
            'label'      => trans('dashboard::menu.posts'),
            'childs'     => true,
            'main'       => true,
            'active'     => ['dashboard.posts.*', 'dashboard.pages.*'],
            'permission' => 'dashboard.posts',
            'sort'       => 100,
            'show'       => count($allPost) > 0,
        ]);

        foreach ($allPost as $key => $page) {
            $route = route('dashboard.posts.type', [$page->slug]);
            if (is_a($page, Single::class)) {
                $route = route('dashboard.pages.show', [$page->slug]);
            }

            $kernel->menu->add('Posts', [
                'slug'       => $page->slug,
                'icon'       => $page->icon,
                'route'      => $route,
                'label'      => $page->name,
                'permission' => 'dashboard.posts.type.'.$page->slug,
                'sort'       => $key,
                'groupname'  => $page->groupname,
                'divider'    => $page->divider,
                'show'       => $page->display,
            ]);
        }

        return $this;
    }

    /**
     * @param Dashboard $kernel
     *
     * @return $this
     */
    protected function registerMenuSystems(Dashboard $kernel): self
    {
        $kernel->menu
            ->add('Main', [
                'slug'       => 'Systems',
                'icon'       => 'icon-layers',
                'route'      => '#',
                'label'      => trans('dashboard::menu.systems'),
                'childs'     => true,
                'main'       => true,
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Systems', [
                'slug'       => 'section',
                'icon'       => 'icon-briefcase',
                'route'      => route('dashboard.systems.category'),
                'label'      => trans('dashboard::menu.sections'),
                'permission' => 'dashboard.systems.category',
                'groupname'  => trans('dashboard::menu.posts Managements'),
                'sort'       => 2,
            ])
            ->add('Systems', [
                'slug'       => 'menu',
                'icon'       => 'icon-menu',
                'route'      => route('dashboard.systems.menu.index'),
                'label'      => trans('dashboard::menu.menu'),
                'permission' => 'dashboard.systems.menu',
                'sort'       => 3,
                'show'       => count(config('press.menu', [])) > 0,
            ])
            ->add('Systems', [
                'slug'       => 'comment',
                'icon'       => 'icon-bubbles',
                'route'      => route('dashboard.systems.comment'),
                'label'      => trans('dashboard::menu.comments'),
                'permission' => 'dashboard.systems.comment',
                'sort'       => 4,
            ])
            ->add('Systems', [
                'slug'       => 'media',
                'icon'       => 'icon-folder-alt',
                'route'      => route('dashboard.systems.media.index'),
                'label'      => trans('dashboard::menu.media'),
                'permission' => 'dashboard.systems.media',
                'sort'       => 5,
            ]);

        return $this;
    }
}
