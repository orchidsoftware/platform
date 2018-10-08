<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Http\Composers;

use Orchid\Platform\ItemMenu;
use Orchid\Platform\Dashboard;

/**
 * Class SystemMenuComposer.
 */
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
                ItemMenu::setLabel(trans('platform::systems/settings.system_menu.Fast start'))
                    ->setSlug('Bulldozer')
                    ->setIcon('icon-code')
            )
            /*
             * TODO: Added generator for Entities
            ->add('Bulldozer', [
                'slug'       => 'Entities',
                'icon'       => 'icon-notebook',
                'route'      => route('platform.bulldozer.index'),
                'label'      => trans('platform::bulldozer.title'),
                'groupname'  => trans('platform::bulldozer.groupname'),
                'active'     => 'platform.bulldozer.*',
                'permission' => 'platform.bulldozer',
                'sort'       => 9000,
            ])
            */
            ->add('Bulldozer',
                ItemMenu::setLabel(trans('platform::bulldozer.title'))
                    ->setIcon('icon-database')
                    ->setRoute(route('platform.bulldozer.index'))
                    ->setPermission('platform.bulldozer')
                    ->setActive('platform.bulldozer.*')
                    ->setGroupName(trans('platform::bulldozer.groupname'))
            );
    }
}
