<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Layouts\SideMenu;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class SideMenuTest extends TestUnitCase
{
    public function testBuildsNavigationView(): void
    {
        $layout = new class extends SideMenu
        {
            protected function label(): string
            {
                return 'Project navigation';
            }

            protected function navigations(): iterable
            {
                return [Menu::make('Dashboard')->href('/dashboard')->divider()];
            }
        };

        $view = $layout->build(new Repository());

        $this->assertSame('orchid::layouts.sideMenu', $view->name());
        $this->assertSame('Project navigation', $view->getData()['label']);
        $this->assertNotEmpty($view->getData()['domId']);
        $this->assertStringContainsString('Dashboard', $view->getData()['navigations']);
        $this->assertStringContainsString('class="divider my-2 border-bottom"', $view->getData()['navigations']);
        $this->assertStringContainsString('role="separator"', $view->getData()['navigations']);
    }

    public function testDoesNotBuildWithoutVisibleNavigation(): void
    {
        $empty = new class extends SideMenu
        {
            protected function navigations(): iterable
            {
                return [];
            }
        };

        $hidden = new class extends SideMenu
        {
            protected function navigations(): iterable
            {
                return [Menu::make('Hidden')->canSee(false)];
            }
        };

        $invisibleLayout = new class extends SideMenu
        {
            protected function navigations(): iterable
            {
                return [Menu::make('Dashboard')];
            }
        };
        $invisibleLayout->canSee(false);

        $this->assertNull($empty->build(new Repository()));
        $this->assertNull($hidden->build(new Repository()));
        $this->assertNull($invisibleLayout->build(new Repository()));
    }

    public function testScopesNestedNavigationAndFiltersHiddenChildren(): void
    {
        $visible = Menu::make('General')->href('/general');
        $hidden = Menu::make('Hidden')->href('/hidden')->canSee(false);
        $parent = Menu::make('Settings')->list([$visible, $hidden]);

        $layout = new class([$parent]) extends SideMenu
        {
            public function __construct(private readonly array $items) {}

            protected function navigations(): iterable
            {
                return $this->items;
            }
        };

        $view = $layout->build(new Repository());
        $domId = $view->getData()['domId'];

        $this->assertSame($domId.'-0', $parent->get('slug'));
        $this->assertSame($domId, $parent->get('parent'));
        $this->assertSame($parent->get('slug'), $visible->get('parent'));
        $this->assertCount(1, $parent->get('list'));
        $this->assertSame(['/general', '/general?*'], $visible->get('active'));
        $this->assertContains('/general/*', $parent->get('active'));
    }

    public function testEachLayoutGetsItsOwnCollapseTarget(): void
    {
        $makeLayout = fn () => new class extends SideMenu
        {
            protected function navigations(): iterable
            {
                return [Menu::make('Dashboard')];
            }
        };

        $first = $makeLayout()->build(new Repository())->getData()['domId'];
        $second = $makeLayout()->build(new Repository())->getData()['domId'];

        $this->assertNotSame($first, $second);
    }
}
