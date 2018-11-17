<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;

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
                ItemMenu::setLabel(__('Content management'))
                    ->setSlug('CMS')
                    ->setIcon('icon-layers')
                    ->setPermission('platform.systems')
                    ->setSort(1000)
            )
            ->add('CMS',
                ItemMenu::setLabel(__('Menu'))
                    ->setIcon('icon-menu')
                    ->setRoute(route('platform.systems.menu.index'))
                    ->setPermission('platform.systems.menu')
                    ->setShow(count(config('press.menu', [])) > 0)
                    ->setGroupName(__('Editing of a custom menu (navigation) using drag & drop and localization support.'))
            )
            ->add('CMS',
                ItemMenu::setLabel(__('Media'))
                    ->setIcon('icon-folder-alt')
                    ->setRoute(route('platform.systems.media.index'))
                    ->setPermission('platform.systems.media')
                    ->setGroupName(__('File Manager allows you to perform the most frequent operations on files - create, open, move, rename, delete'))
            );
    }
}
