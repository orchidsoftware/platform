<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Http\Composers;

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
            ->add('Systems', [
                'slug'       => 'Bulldozer',
                'icon'       => 'icon-code',
                'label'      => trans('platform::systems/settings.system_menu.Fast start'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems',
                'sort'       => 9000,
            ])
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
            ->add('Bulldozer', [
                'slug'       => 'Models',
                'icon'       => 'icon-database',
                'route'      => route('platform.bulldozer.index'),
                'label'      => trans('platform::bulldozer.title'),
                'groupname'  => trans('platform::bulldozer.groupname'),
                'active'     => 'platform.bulldozer.*',
                'permission' => 'platform.bulldozer',
                'sort'       => 9000,
            ]);
    }
}
