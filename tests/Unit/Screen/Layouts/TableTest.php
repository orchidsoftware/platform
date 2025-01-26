<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Tests\App\Layouts\TotalTable;
use Orchid\Tests\TestUnitCase;

class TableTest extends TestUnitCase
{
    public function test_total_row(): void
    {
        $layout = new TotalTable;

        $html = $layout
            ->build(TotalTable::getData())
            ->render();

        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('Total:', $html);
        $this->assertStringContainsString('600', $html);
    }

    public function test_can_see(): void
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

    public function test_striped(): void
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

    public function test_bordered(): void
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

    public function test_hoverable(): void
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

    public function test_show_text_not_found_when_target_is_empty_collection()
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

        $this->assertStringContainsString('There are no objects currently displayed', $html);
        $this->assertNotEmpty($html);
    }

    public function test_loop_table(): void
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
    }
}
