<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\ItemMenu;
use Orchid\Platform\Dashboard;
use Orchid\Tests\TestUnitCase;

/**
 * Class MenuTest.
 */
class MenuTest extends TestUnitCase
{
    public function testIsMenu()
    {
        $menu = (new Dashboard())->menu;

        $menu->add('Main', ItemMenu::setLabel('Main Test')
            ->setSlug('Test')
            ->setIcon('icon-layers')
            ->setChilds()
            ->setSort(1000)
        );

        $this->assertEquals(! is_null($menu->render('Main')), true);
        $this->assertEquals($menu->container->count(), 1);

        $menu->add('Test', ItemMenu::setLabel('Users')
            ->setSlug('users')
            ->setIcon('icon-user')
            ->setChilds(false)
            ->setDivider(false)
            ->setSort(503)
        );

        $this->assertEquals(! is_null($menu->render('Test')), true);
    }

    public function test_count_location()
    {
        $menu = (new Dashboard())->menu;

        $menu->add('CountPlace', ItemMenu::setLabel('Main Test')
            ->setSlug('CountPlace 1')
            ->setIcon('icon-layers')
            ->setChilds()
            ->setSort(1000)
        );

        $menu->add('CountPlace', ItemMenu::setLabel('Main Test')
            ->setSlug('CountPlace 2')
            ->setIcon('icon-layers')
            ->setChilds()
            ->setSort(1000)
        );

        $count = $menu->showCountElement('CountPlace');

        $this->assertEquals(2, $count);
    }

    public function test_show()
    {
        $menu = (new Dashboard())->menu;

        $menu->add('Main', ItemMenu::setLabel('No Display')
            ->setChilds()
            ->setSort(1000)
            ->setShow(false)
        );

        $count = $menu->showCountElement('Main');

        $this->assertEquals(0, $count);
    }
}
