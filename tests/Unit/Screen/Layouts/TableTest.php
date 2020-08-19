<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Tests\App\Layouts\TotalTable;
use Orchid\Tests\TestUnitCase;

class TableTest extends TestUnitCase
{
    public function testTotalRow(): void
    {
        $layout = new TotalTable();

        $html = $layout
            ->build(TotalTable::getData())
            ->render();

        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('Total:', $html);
        $this->assertStringContainsString('600', $html);
    }
}
