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
                'slug'       => 'Developer',
                'icon'       => 'icon-code',
                'label'      => 'Разработка',
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems',
                'sort'       => 9000,
            ])
            ->add('Developer', [
                'slug'       => 'boot',
                'icon'       => 'icon-energy',
                'route'      => route('platform.boot.index'),
                'label'      => 'Быстрый старт',
                'groupname'  => 'Позволяет максимально быстро начать разрабатывать приложение',
                'active'     => 'platform.boot.*',
                'permission' => 'platform.boot',
                'sort'       => 9000,
            ]);
    }
}
