<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\Menu;
use Orchid\Tests\TestUnitCase;

/**
 * Class MenuTest.
 */
class MenuTest extends TestUnitCase
{
    public function testIsMenu(): void
    {
        $menu = (new Dashboard())->menu;

        $menu->add(Menu::MAIN, ItemMenu::label('Main Test')
            ->slug('Test')
            ->icon('icon-layers')
            ->childs()
            ->sort(1000)
        );

        $this->assertNotNull($menu->render('Main'));
        $this->assertEquals(1, $menu->container->count());

        $menu->add('Test', ItemMenu::label('Users')
            ->slug('users')
            ->icon('icon-user')
            ->childs(false)
            ->divider(false)
            ->sort(503)
        );

        $this->assertNotNull($menu->render('Test'));
        $this->assertStringContainsString('Users', $menu->render('Test'));
    }

    public function testCountLocation(): void
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

    public function testCanSee(): void
    {
        $menu = (new Dashboard())->menu;

        $menu->add(Menu::MAIN, ItemMenu::label('No Display')
            ->childs()
            ->sort(1000)
            ->canSee(false)
        );

        $count = $menu->showCountElement('Main');

        $this->assertEquals(0, $count);
    }

    public function testChildEmpty(): void
    {
        $menu = (new Dashboard())->menu;

        $menu->add(Menu::MAIN, ItemMenu::label('Dropdown menu')
            ->slug('example-menu')
            ->childs()
            ->hideEmpty()
        )
            ->add('example-menu', ItemMenu::label('Sub element item 1')->canSee(false))
            ->add('example-menu', ItemMenu::label('Sub element item 2')->canSee(false));

        $count = $menu->showCountElement('example-menu');

        $this->assertEquals(0, $count);
        $this->assertEmpty($menu->render('example-menu'));
        $this->assertEmpty($menu->render(Menu::MAIN));
    }

    public function testChildNotEmpty(): void
    {
        $menu = (new Dashboard())->menu;

        $menu->add(Menu::MAIN, ItemMenu::label('Dropdown menu')
            ->slug('example-menu')
            ->childs()
            ->hideEmpty()
        )
            ->add('example-menu', ItemMenu::label('Sub element item 1')->canSee(false))
            ->add('example-menu', ItemMenu::label('Sub element item 2')->canSee(true));

        $count = $menu->showCountElement('example-menu');

        $this->assertEquals(1, $count);
        $this->assertNotEmpty($menu->render('example-menu'));
        $this->assertNotEmpty($menu->render(Menu::MAIN));
    }

    public function testChildShowEmpty(): void
    {
        $menu = (new Dashboard())->menu;

        $menu->add(Menu::MAIN, ItemMenu::label('Dropdown menu')
            ->slug('example-menu')
            ->childs()
        );

        $this->assertStringContainsString('Dropdown menu', $menu->render(Menu::MAIN));
    }
}
