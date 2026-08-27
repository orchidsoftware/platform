<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Tests\App\Layouts\TotalTable;
use Orchid\Tests\TestUnitCase;

class TableTest extends TestUnitCase
{
    public function testTotalRow(): void
    {
        $layout = new TotalTable;

        $html = $layout
            ->build(TotalTable::getData())
            ->render();

        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('Total:', $html);
        $this->assertStringContainsString('600', $html);
    }

    public function testCanSee(): void
    {
        $layout = new class extends Table
        {
            protected $target = 'target';

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
        $layout = new class extends Table
        {
            protected $target = 'target';

            protected function columns(): array
            {
                return [];
            }

            protected function striped(): bool
            {
                return true;
            }
        };

        $html = $layout
            ->build(new Repository(['target' => []]))
            ->render();

        $this->assertStringContainsString('table-striped', $html);
    }

    public function testBordered(): void
    {
        $layout = new class extends Table
        {
            protected $target = 'target';

            protected function columns(): array
            {
                return [];
            }

            protected function bordered(): bool
            {
                return true;
            }
        };

        $html = $layout
            ->build(new Repository(['target' => []]))
            ->render();

        $this->assertStringContainsString('table-bordered', $html);
    }

    public function testHoverable(): void
    {
        $layout = new class extends Table
        {
            protected $target = 'target';

            protected function columns(): array
            {
                return [];
            }

            protected function hoverable(): bool
            {
                return true;
            }
        };

        $html = $layout
            ->build(new Repository(['target' => []]))
            ->render();

        $this->assertStringContainsString('table-hover', $html);
    }

    public function testShowTextNotFoundWhenTargetIsEmptyCollection()
    {
        $layout = new class extends Table
        {
            protected $target = 'target';

            protected function columns(): array
            {
                return [];
            }
        };

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
            $layout = new class extends Table
            {
                protected $target = 'target';

                protected function columns(): array
                {
                    return [];
                }
            };

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
            $layout = new class extends Table
            {
                protected $target = 'target';

                protected function columns(): array
                {
                    return [];
                }
            };

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
            $layout = new class extends Table
            {
                protected $target = 'target';

                protected function columns(): array
                {
                    return [];
                }
            };

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
        $layout = new class extends Table
        {
            protected $target = 'target';

            protected function columns(): array
            {
                return [];
            }

            protected function emptyStateIcon(): string
            {
                return 'bs.archive';
            }

            protected function emptyStateTitle(): string
            {
                return 'No appointments';
            }

            protected function emptyStateDescription(): string
            {
                return 'Create the first appointment.';
            }

            protected function emptyStateAction(): ?Action
            {
                return Link::make('Create appointment')->href('/appointments/create');
            }
        };

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
        $layout = new class extends Table
        {
            protected $target = 'target';

            protected function columns(): array
            {
                return [
                    TD::make('serial number')->render(fn ($item, $loop) => 'index:'.$loop->index),
                ];
            }
        };

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
