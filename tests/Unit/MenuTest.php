<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Tests\TestUnitCase;

/**
 * Class MenuTest.
 */
class MenuTest extends TestUnitCase
{
    public function testIsMenu()
    {
        $menu = (new Dashboard())->menu;

        $menu->add('Main', ItemMenu::label('Main Test')
            ->slug('Test')
            ->icon('icon-layers')
            ->childs()
            ->sort(1000)
        );

        $this->assertEquals(! is_null($menu->render('Main')), true);
        $this->assertEquals($menu->container->count(), 1);

        $menu->add('Test', ItemMenu::label('Users')
            ->slug('users')
            ->icon('icon-user')
            ->childs(false)
            ->divider(false)
            ->sort(503)
        );

        $this->assertEquals(! is_null($menu->render('Test')), true);
    }

    public function testCountLocation()
    {
        $menu = (new Dashboard())->menu;

        $menu->add('CountPlace', ItemMenu::label('Main Test')
            ->slug('CountPlace 1')
            ->icon('icon-layers')
            ->childs()
            ->sort(1000)
        );

        $menu->add('CountPlace', ItemMenu::label('Main Test')
            ->slug('CountPlace 2')
            ->icon('icon-layers')
            ->childs()
            ->sort(1000)
        );

        $count = $menu->showCountElement('CountPlace');

        $this->assertEquals(2, $count);
    }

    public function testCanSee()
    {
        $menu = (new Dashboard())->menu;

        $menu->add('Main', ItemMenu::label('No Display')
            ->childs()
            ->sort(1000)
            ->canSee(false)
        );

        $count = $menu->showCountElement('Main');

        $this->assertEquals(0, $count);
    }
}
