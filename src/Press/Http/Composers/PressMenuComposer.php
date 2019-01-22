<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\ItemMenu;
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
        $this->dashboard->getEntities()
            ->where('display', true)
            ->sortBy('sort')
            ->each(function ($page) use ($kernel) {
                $route = is_a($page, Single::class) ? 'platform.entities.type.edit' : 'platform.entities.type';

                $kernel->menu->add('Main',
                    ItemMenu::setLabel($page->name)
                        ->setSlug($page->slug)
                        ->setIcon($page->icon)
                        ->setGroupName($page->groupname)
                        ->setRoute(route($route, [$page->slug]))
                        ->setPermission('platform.entities.type'.$page->slug)
                        ->setActive(route($route, [$page->slug]).'*')
                        ->setSort($page->sort)
                        ->setShow($page->display)
                );
            });

        return $this;
    }
}
