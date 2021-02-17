<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Tests\TestUnitCase;

class TDForTableTest extends TestUnitCase
{
    public function testShowPopover(): void
    {
        $popover = 'Vivamus sagittis lacus vel augue laoreet rutrum faucibus.';

        $view = TD::make('name')->popover($popover)->buildTh();

        $this->assertStringContainsString($popover, $view);
    }

    public function testTdWidth(): void
    {
        $width = '100px';

        $view = TD::make('name')->width($width)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="width:'.$width.'"', $view);
    }

    public function testTdWithoutWidth(): void
    {
        $view = TD::make('name')->buildTd(new Repository(['name' => 'value']));

        $this->assertStringNotContainsString('style="width:"', $view);
    }

    public function testTdWidthNumeric(): void
    {
        $integer = 100;

        $view = TD::make('name')->width($integer)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="width:'.$integer.'px"', $view);

        $float = 100.51;

        $view = TD::make('name')->width($float)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="width:'.$float.'px"', $view);
    }

    public function testTdWidthString(): void
    {
        $stringWithInteger = '100';

        $view = TD::make('name')->width($stringWithInteger)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="width:'.$stringWithInteger.'px"', $view);

        $stringWithFloat = '100.50';

        $view = TD::make('name')->width($stringWithFloat)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="width:'.$stringWithFloat.'px"', $view);

        $stringWithNotOnlyNumeric = '100em';

        $view = TD::make('name')->width($stringWithNotOnlyNumeric)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="width:'.$stringWithNotOnlyNumeric.'"', $view);
    }
}
