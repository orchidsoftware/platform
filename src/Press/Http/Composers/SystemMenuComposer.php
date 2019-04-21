<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

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
                ItemMenu::label(__('Content management'))
                    ->slug('CMS')
                    ->icon('icon-layers')
                    ->permission('platform.systems')
                    ->sort(1000)
            )
            ->add('CMS',
                ItemMenu::label(__('Menu'))
                    ->icon('icon-menu')
                    ->route('platform.systems.menu.index')
                    ->permission('platform.systems.menu')
                    ->show(count(config('press.menu', [])) > 0)
                    ->title(__('Editing of a custom menu (navigation) using drag & drop and localization support.'))
            );
    }
}
