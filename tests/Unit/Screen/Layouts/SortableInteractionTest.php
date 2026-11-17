<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Sortable;
use Orchid\Screen\Repository;
use Orchid\Screen\Sight;
use Orchid\Tests\TestUnitCase;

class SortableInteractionTest extends TestUnitCase
{
    public function testEmptySortableUsesSharedEmptyState(): void
    {
        $layout = new class('target', []) extends Sortable
        {
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

    public function testEmptySortableRendersAndRemovesItsConfiguredAction(): void
    {
        $layout = Sortable::make('items', [])
            ->emptyAction(Link::make('Create item')->href('/items/create'));
        $repository = new Repository(['items' => []]);

        $html = $layout->build($repository)->render();

        self::assertStringContainsString('Create item', $html);
        self::assertStringContainsString('href="/items/create"', $html);

        $html = $layout->emptyAction(null)->build($repository)->render();

        self::assertStringNotContainsString('Create item', $html);
        self::assertStringNotContainsString('/items/create', $html);
    }

    public function testEmptySortableIgnoresFiltersElsewhereOnTheScreen(): void
    {
        $query = request()->query->all();

        request()->query->replace(['filter' => ['name' => 'missing']]);

        try {
            $layout = new class('target', []) extends Sortable
            {
                protected function columns(): iterable
                {
                    return [];
                }
            };

            $html = $layout->build(new Repository([
                'target' => collect([]),
            ]))->render();

            self::assertStringContainsString('No items yet', $html);
            self::assertStringContainsString('New items will appear here.', $html);
            self::assertStringNotContainsString('No matches', $html);
            self::assertStringNotContainsString('Clear filters', $html);
        } finally {
            request()->query->replace($query);
        }
    }

    public function testEmptySortableCanBeOverridden(): void
    {
        $layout = new class('target', []) extends Sortable
        {
            protected function columns(): iterable
            {
                return [];
            }

            protected function iconNotFound(): string
            {
                return 'bs.archive';
            }

            protected function textNotFound(): string
            {
                return 'No appointments';
            }

            protected function subNotFound(): string
            {
                return 'Create the first appointment.';
            }
        };

        $html = $layout->build(new Repository([
            'target' => collect([]),
        ]))->render();

        self::assertStringContainsString('bs.archive', $html);
        self::assertStringContainsString('No appointments', $html);
        self::assertStringContainsString('Create the first appointment.', $html);
        self::assertStringNotContainsString('No items yet', $html);
    }

    public function testSortableUsesAnExplicitReorderHandle(): void
    {
        $model = new class(['id' => 1, 'name' => 'First item']) extends Repository
        {
            public function getKey(): int
            {
                return $this->get('id');
            }
        };

        $html = view('orchid::layouts.sortable', [
            'rows'               => collect([$model]),
            'columns'            => collect([Sight::make('name', 'Name')]),
            'title'              => null,
            'showBlockHeaders'   => false,
            'iconNotFound'       => null,
            'textNotFound'       => '',
            'subNotFound'        => '',
            'successSortMessage' => 'Sorted',
            'failureSortMessage' => 'Failed',
        ])->render();

        self::assertStringContainsString('data-model-id="1"', $html);
        self::assertStringContainsString('class="reorder-handle btn btn-link', $html);
        self::assertStringContainsString('aria-label="Reorder"', $html);
        self::assertStringContainsString('keydown.up->sortable#moveUp', $html);
        self::assertStringContainsString('keydown.down->sortable#moveDown', $html);
        self::assertStringNotContainsString('list-group-item-action', $html);
    }
}
