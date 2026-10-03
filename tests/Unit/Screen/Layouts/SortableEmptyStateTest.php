<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Layouts\Sortable;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class SortableEmptyStateTest extends TestUnitCase
{
    public function testEmptySortableUsesSharedEmptyState(): void
    {
        $layout = new class extends Sortable
        {
            protected $target = 'target';

            protected function columns(): iterable
            {
                return [];
            }
        };

        $html = $layout->build(new Repository([
            'target' => collect([]),
        ]))->render();

        self::assertStringContainsString('class="empty-state ', $html);
        self::assertStringContainsString('No items yet', $html);
        self::assertStringContainsString('New items will appear here.', $html);
    }

    public function testEmptySortableCanClearActiveFilters(): void
    {
        $query = request()->query->all();

        request()->query->replace([
            'filter' => ['name' => 'missing'],
            'page'   => 2,
            'sort'   => 'name',
        ]);

        try {
            $layout = new class extends Sortable
            {
                protected $target = 'target';

                protected function columns(): iterable
                {
                    return [];
                }
            };

            $html = $layout->build(new Repository(['target' => []]))->render();

            self::assertStringContainsString('No matches', $html);
            self::assertStringContainsString('Try changing or clearing the filters.', $html);
            self::assertStringContainsString('Clear filters', $html);
            self::assertStringContainsString('sort=name', $html);
            self::assertStringNotContainsString('filter%5Bname%5D', $html);
            self::assertStringNotContainsString('page=2', $html);
        } finally {
            request()->query->replace($query);
        }
    }
}
