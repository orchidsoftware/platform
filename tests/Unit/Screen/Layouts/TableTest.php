<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Tests\TestUnitCase;

class TableTest extends TestUnitCase
{
    public function testCanSee(): void
    {
        $layout = new class('target', []) extends Table
        {
            protected function columns(): array
            {
                return [];
            }

            public function isSee(): bool
            {
                return $this->query->get('visible');
            }
        };

        $empty = $layout->build(new Repository([
            'visible' => false,
            'target'  => [],
        ]));

        $this->assertEmpty($empty);

        $html = $layout->build(new Repository([
            'visible' => true,
            'target'  => [],
        ]))->render();

        $this->assertNotEmpty($html);
    }

    public function testStriped(): void
    {
        $layout = Table::make('target', [])->striped();

        $html = $layout
            ->build(new Repository(['target' => []]))
            ->render();

        $this->assertStringContainsString('table-striped', $html);
    }

    public function testBordered(): void
    {
        $layout = Table::make('target', [])->bordered();

        $html = $layout
            ->build(new Repository(['target' => []]))
            ->render();

        $this->assertStringContainsString('table-bordered', $html);
    }

    public function testHoverable(): void
    {
        $layout = Table::make('target', [])->hoverable();

        $html = $layout
            ->build(new Repository(['target' => []]))
            ->render();

        $this->assertStringContainsString('table-hover', $html);
    }

    public function testShowTextNotFoundWhenTargetIsEmptyCollection()
    {
        $layout = Table::make('target', []);

        $html = $layout->build(new Repository([
            'target'  => collect([]),
        ]))->render();

        $this->assertStringContainsString('No items yet', $html);
        $this->assertStringContainsString('New items will appear here.', $html);
        $this->assertStringContainsString('class="empty-state ', $html);
        $this->assertMatchesRegularExpression('/<table class="[^"]*\bmb-0\b[^"]*">/', $html);
        $this->assertStringNotContainsString('bs.arrow-counterclockwise', $html);
        $this->assertNotEmpty($html);
    }

    public function testShowResetActionWhenFiltersHaveNoResults(): void
    {
        $query = request()->query->all();

        request()->query->replace([
            'filter' => ['name' => 'missing'],
            'page'   => 2,
            'sort'   => 'name',
            'tab'    => 'active',
        ]);

        try {
            $layout = Table::make('target', []);

            $html = $layout->build(new Repository([
                'target' => collect([]),
            ]))->render();

            $this->assertStringContainsString('No matches', $html);
            $this->assertStringContainsString('Try changing or clearing the filters.', $html);
            $this->assertStringContainsString('class="empty-state ', $html);
            $this->assertStringContainsString('bs.arrow-counterclockwise', $html);
            $this->assertStringContainsString('Clear filters', $html);
            $this->assertStringContainsString('sort=name', $html);
            $this->assertStringContainsString('tab=active', $html);
            $this->assertStringNotContainsString('filter%5Bname%5D', $html);
            $this->assertStringNotContainsString('page=2', $html);
        } finally {
            request()->query->replace($query);
        }
    }

    public function testPaginationAndSortingDoNotCountAsFilters(): void
    {
        $query = request()->query->all();

        request()->query->replace([
            'page' => 2,
            'sort' => 'name',
            'tab'  => 'active',
        ]);

        try {
            $layout = Table::make('target', []);

            $html = $layout->build(new Repository([
                'target' => collect([]),
            ]))->render();

            $this->assertStringContainsString('No items yet', $html);
            $this->assertStringNotContainsString('Clear filters', $html);
        } finally {
            request()->query->replace($query);
        }
    }

    public function testEmptyFilterValuesDoNotCountAsActiveFilters(): void
    {
        $query = request()->query->all();

        request()->query->replace([
            'filter' => [
                'name'  => '',
                'range' => ['start' => null, 'end' => ''],
            ],
        ]);

        try {
            $layout = Table::make('target', []);

            $html = $layout->build(new Repository([
                'target' => collect([]),
            ]))->render();

            $this->assertStringContainsString('No items yet', $html);
            $this->assertStringNotContainsString('Clear filters', $html);
        } finally {
            request()->query->replace($query);
        }
    }

    public function testEmptyStateCanBeOverridden(): void
    {
        $layout = Table::make('target', [])->emptyIcon('bs.archive')->emptyTitle('No appointments')->emptyDescription('Create the first appointment.')->emptyAction(Link::make('Create appointment')->href('/appointments/create'));

        $html = $layout->build(new Repository([
            'target' => collect([]),
        ]))->render();

        $this->assertStringContainsString('bs.archive', $html);
        $this->assertStringContainsString('No appointments', $html);
        $this->assertStringContainsString('Create the first appointment.', $html);
        $this->assertStringContainsString('Create appointment', $html);
        $this->assertStringContainsString('href="/appointments/create"', $html);
        $this->assertStringNotContainsString('Clear filters', $html);
    }

    public function testLoopTable(): void
    {
        $layout = Table::make('target', [
            TD::make('serial number')->render(fn ($item, $loop) => 'index:'.$loop->index),
        ]);

        $values = collect(['a', 'b', 'c']);

        $html = $layout->build(new Repository([
            'target'  => $values,
        ]))->render();

        $values->each(function ($item, $key) use ($html) {
            $this->assertStringContainsString('index:'.$key, $html);
        });

        $this->assertDoesNotMatchRegularExpression('/<table class="[^"]*\bmb-0\b[^"]*">/', $html);
    }
}
