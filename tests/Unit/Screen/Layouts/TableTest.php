<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
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

    public function testCanSee(): void
    {
        $layout = new class extends Table {
            protected $target = 'target';

            protected function columns(): array
            {
                return [];
            }

            public function canSee(Repository $query): bool
            {
                return $query->get('visible');
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
        $layout = new class extends Table {
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
        $layout = new class extends Table {
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
}
