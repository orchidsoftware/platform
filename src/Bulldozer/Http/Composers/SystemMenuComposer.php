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
                'label'      => 'Быстрый старт',
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems',
                'sort'       => 9000,
            ])
            ->add('Bulldozer', [
                'slug'       => 'Entities',
                'icon'       => 'icon-notebook',
                'route'      => route('platform.boot.index'),
                'label'      => 'Строитель моделей',
                'groupname'  => 'Позволяет максимально быстро начать разрабатывать приложение',
                'active'     => 'platform.boot.*',
                'permission' => 'platform.boot',
                'sort'       => 9000,
            ])
            ->add('Bulldozer', [
                'slug'       => 'Models',
                'icon'       => 'icon-database',
                'route'      => route('platform.boot.index'),
                'label'      => 'Строитель моделей',
                'groupname'  => 'Позволяет максимально быстро начать разрабатывать приложение',
                'active'     => 'platform.boot.*',
                'permission' => 'platform.boot',
                'sort'       => 9000,
            ]);
    }
}
