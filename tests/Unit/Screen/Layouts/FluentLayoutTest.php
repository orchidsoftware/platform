<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Illuminate\Support\Collection;
use LogicException;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\SideMenu;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Layouts\TabMenu;
use Orchid\Screen\Layouts\View;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\TestUnitCase;

class FluentLayoutTest extends TestUnitCase
{
    public function testNestedConcreteLayoutsRenderFieldsAndRemainDiscoverable(): void
    {
        $rows = Rows::make([Input::make('name')])->title('Profile');
        $layout = Columns::make([$rows, Layout::rows([Input::make('email')])]);

        $html = $layout->build(new Repository([
            'name'  => 'Taylor',
            'email' => 'taylor@example.com',
        ]))->render();

        $this->assertStringContainsString('Profile', $html);
        $this->assertStringContainsString('Taylor', $html);
        $this->assertStringContainsString('taylor@example.com', $html);
        $this->assertSame($rows, $layout->findByType(Rows::class));
        $this->assertSame($rows, $layout->findBySlug($rows->getSlug()));
    }

    public function testFieldsUseTheCurrentRepositoryOnEachBuild(): void
    {
        $rows = Rows::make([Input::make('name')]);

        $first = $rows->build(new Repository(['name' => 'Taylor']))->render();
        $second = $rows->build(new Repository(['name' => 'Alex']))->render();

        $this->assertStringContainsString('Taylor', $first);
        $this->assertStringContainsString('Alex', $second);
        $this->assertStringNotContainsString('Taylor', $second);
    }

    public function testDirectAndFacadeTablesRenderTheSameDataAndTotals(): void
    {
        foreach ([Table::make([TD::make('name')]), Layout::table([TD::make('name')])] as $table) {
            $html = $table->target('users')->title('Team')
                ->totals([TD::make('count')])
                ->build(new Repository([
                    'users' => [new Repository(['name' => 'Taylor'])],
                    'count' => 42,
                ]))->render();

            $this->assertStringContainsString('Team', $html);
            $this->assertStringContainsString('Taylor', $html);
            $this->assertStringContainsString('42', $html);
        }
    }

    public function testTableRequiresAnExplicitDataSource(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('target()');

        Table::make([TD::make('name')])->build(new Repository);
    }

    public function testNamedMenusCanStillSupplyTheirNavigation(): void
    {
        $menu = new class extends TabMenu
        {
            protected function navigations(): iterable
            {
                return [Menu::make('Settings')->href('/settings')];
            }
        };

        $html = $menu::make()->build(new Repository)->render();

        $this->assertStringContainsString('Settings', $html);
        $this->assertStringContainsString('/settings', $html);
    }

    public function testNavigationCanBeConfiguredWithoutSubclassing(): void
    {
        $html = SideMenu::make([Menu::make('Settings')->href('/settings')])
            ->label('Account navigation')
            ->build(new Repository)->render();

        $this->assertStringContainsString('Account navigation', $html);
        $this->assertStringContainsString('Settings', $html);
        $this->assertStringContainsString('/settings', $html);
    }

    public function testEmptyActionCanExplicitlyDisableTheFilterResetLink(): void
    {
        $query = request()->query->all();
        request()->query->set('filter', ['name' => 'missing']);

        try {
            $html = Table::make([])->target('users')->emptyAction(null)
                ->build(new Repository(['users' => []]))->render();

            $this->assertStringContainsString('No matches', $html);
            $this->assertStringNotContainsString('Clear filters', $html);
        } finally {
            request()->query->replace($query);
        }
    }

    public function testViewAcceptsArrayableDataAndScreenValuesTakePrecedence(): void
    {
        $html = View::make('exemplar::alert', new Collection(['name' => 'Default']))
            ->build(new Repository(['name' => 'Taylor']))->render();

        $this->assertStringContainsString('Hello Taylor!', $html);
        $this->assertStringNotContainsString('Default', $html);
    }
}
