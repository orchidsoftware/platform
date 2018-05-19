<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Press\Entities\Single;

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
            ->registerMenuPost($this->dashboard);
    }

    /**
     * @param Dashboard $kernel
     *
     * @return $this
     */
    protected function registerMenuPost(Dashboard $kernel): self
    {
        $allPost = $this->dashboard->getEntities()
            ->where('display', true)
            ->all();

        $kernel->menu->add('Main', [
            'slug'       => 'Posts',
            'icon'       => 'icon-notebook',
            'route'      => '#',
            'label'      => trans('platform::menu.posts'),
            'childs'     => true,
            'main'       => true,
            'active'     => ['platform.posts.*', 'platform.pages.*'],
            'permission' => 'platform.posts',
            'sort'       => 100,
            'show'       => count($allPost) > 0,
        ]);

        foreach ($allPost as $key => $page) {
            $route = route('platform.posts.type', [$page->slug]);
            if (is_a($page, Single::class)) {
                $route = route('platform.pages.show', [$page->slug]);
            }

            $kernel->menu->add('Posts', [
                'slug'       => $page->slug,
                'icon'       => $page->icon,
                'route'      => $route,
                'label'      => $page->name,
                'permission' => 'platform.posts.type.'.$page->slug,
                'sort'       => $key,
                'groupname'  => $page->groupname,
                'divider'    => $page->divider,
                'show'       => $page->display,
            ]);
        }

        return $this;
    }
}
