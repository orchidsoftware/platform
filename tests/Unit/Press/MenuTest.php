<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Press;

use Orchid\Press\Models\Menu;
use Orchid\Tests\TestUnitCase;

class MenuTest extends TestUnitCase
{
    /**
     * @test
     */
    public function testHasCorrectInstance()
    {
        $menu = factory(Menu::class)->create(['type' => 'header']);

        $this->assertNotNull($menu);
        $this->assertInstanceOf(Menu::class, $menu);
        $this->assertEquals(1, $menu->id);
    }

    /**
     * @test
     */
    public function testCanQueryMenuChildren()
    {
        $this->createMenuWithChildren();
        $menu = Menu::where('parent', 0)->get()->first();

        $this->assertEquals(3, $menu->children()->count());
        $this->assertInstanceOf(Menu::class, $menu->children()->first());
        $this->assertEquals(4, $menu->children()->first()->id);
    }

    /**
     * @return array
     */
    private function createMenuWithChildren()
    {
        $menu = factory(Menu::class)->create(['type' => 'header']);

        $menus[] = $menu;

        for ($i = 1; $i <= 3; $i++) {
            $menus[] = factory(Menu::class)->create([
                'type'   => 'header',
                'parent' => $menu->id,
                'sort'   => 3 - $i,
            ]);
        }

        return $menus;
    }

    /**
     * @test
     */
    public function testCanQueryMenuParent()
    {
        $this->createMenuWithChildren();
        $menu = Menu::where('parent', 0)->get()->first();
        $menu_child = $menu->children()->first();

        $this->assertInstanceOf(Menu::class, $menu_child->parent()->first());
        $this->assertEquals($menu->id, $menu_child->parent()->first()->id);
    }
}
