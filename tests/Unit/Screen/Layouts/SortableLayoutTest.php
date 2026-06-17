<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Repository;
use Orchid\Tests\App\Layouts\EagerRowDetailSortable;
use Orchid\Tests\App\RowDetailItem;
use Orchid\Tests\TestUnitCase;

class SortableLayoutTest extends TestUnitCase
{
    public function testEagerRowDetail(): void
    {
        $layout = new EagerRowDetailSortable;

        $html = $layout
            ->build(new Repository([
                'target' => [
                    new RowDetailItem(['id' => 1, 'name' => 'first']),
                ],
            ]))
            ->render();

        $this->assertStringContainsString('data-action="sortable#toggleDetail"', $html);
        $this->assertStringContainsString('data-row-detail-row', $html);
        $this->assertStringContainsString('detail:first:0', $html);
    }
}
