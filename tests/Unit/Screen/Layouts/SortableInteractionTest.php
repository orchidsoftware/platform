<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Repository;
use Orchid\Screen\Sight;
use Orchid\Tests\TestUnitCase;

class SortableInteractionTest extends TestUnitCase
{
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
