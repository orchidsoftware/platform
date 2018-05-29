<?php

declare(strict_types=1);

namespace Orchid\Boot\Http\Composers;

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
            ->add('Systems', [
                'slug'       => 'Developer',
                'icon'       => 'icon-code',
                'label'      => 'Разработка',
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems',
                'sort'       => 2000,
            ])
            ->add('Boot', [
                'slug'       => 'boot',
                'icon'       => 'icon-energy',
                'route'      => route('platform.boot.index'),
                'label'      => 'Быстрый старт',
                'groupname'  => 'Позволяет максимально быстро начать разрабатывать приложение',
                'active'     => 'platform.boot.*',
                'permission' => 'platform.boot',
                'sort'       => 1000,
            ]);
    }
}
