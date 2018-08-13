<?php

declare(strict_types=1);

namespace Orchid\Savior\Http\Composers;

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
                'slug'       => 'Savior',
                'icon'       => 'icon-umbrella',
                'label'      => 'Журналирование',
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems',
                'sort'       => 9000,
            ])
            ->add('Savior', [
                'slug'       => 'backups',
                'icon'       => 'icon-clock',
                'route'      => route('platform.savior.backups'),
                'label'      => 'Резервные копии',
                'groupname'  => 'Необходимо для возможности быстрого восстановления информации в случае утери рабочей копии.',
                'childs'     => false,
                'divider'    => false,
                'permission' => 'platform.savior.backups',
                'sort'       => 1,
            ]);
    }
}
