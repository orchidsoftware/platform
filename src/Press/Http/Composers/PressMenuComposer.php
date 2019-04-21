<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Menu;
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
                $route = is_a($page, Single::class) ? 'platform.entities.type.page' : 'platform.entities.type';
                $params = is_a($page, Single::class) ? [$page->slug, $page->slug] : [$page->slug];

                $kernel->menu->add(Menu::MAIN,
                    ItemMenu::label($page->name)
                        ->slug($page->slug)
                        ->icon($page->icon)
                        ->title(/* property groupname id @deprecated */ $page->groupname ??  $page->title)
                        ->route($route, $params)
                        ->permission('platform.entities.type.'.$page->slug)
                        ->sort($page->sort)
                        ->show($page->display)
                );
            });

        return $this;
    }
}
