<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Tests\TestUnitCase;

/**
 * Class MenuTest.
 */
class MenuTest extends TestUnitCase
{
    /**
     * Verify permissions.
     */
    public function testIsMenu()
    {
        $menu = (new Dashboard())->menu;

        $menu->add('Main', [
            'slug'   => 'Test',
            'icon'   => 'icon-layers',
            'route'  => '#',
            'label'  => 'Main Test',
            'childs' => true,
            'main'   => true,
            'sort'   => 1000,
        ]);

        $this->assertEquals(!is_null($menu->render('Main')), true);
        $this->assertEquals($menu->container->count(), 1);

        $menu->add('Test', [
            'slug'    => 'users',
            'icon'    => 'icon-user',
            'route'   => '#',
            'label'   => 'Sup Test',
            'childs'  => false,
            'divider' => false,
            'sort'    => 503,
        ]);

        $this->assertEquals(!is_null($menu->render('Test')), true);
    }


    public function test_count_location()
    {

        $menu = (new Dashboard())->menu;

        $menu->add('CountPlace', [
            'slug'   => 'CountPlace 1',
            'icon'   => 'icon-layers',
            'route'  => '#',
            'label'  => 'Main Test',
            'childs' => true,
            'main'   => true,
            'sort'   => 1000,
        ]);

        $menu->add('CountPlace', [
            'slug'   => 'CountPlace 2',
            'icon'   => 'icon-layers',
            'route'  => '#',
            'label'  => 'Main Test',
            'childs' => true,
            'main'   => true,
            'sort'   => 1000,
        ]);


        $count = $menu->showCountElement('CountPlace');

        $this->assertEquals(2, $count);
    }
}
