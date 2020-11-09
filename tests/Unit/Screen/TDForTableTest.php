<?php

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Tests\TestUnitCase;

class TDForTableTest extends TestUnitCase
{
    public function testShowPopover(): void
    {
        $popover = 'Vivamus sagittis lacus vel augue laoreet rutrum faucibus.';

        $view = TD::set('name')->popover($popover)->buildTh();

        $this->assertStringContainsString($popover, $view);
    }

    public function testTdWidth(): void
    {
        $width = '100px';

        $view = TD::set('name')->width($width)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('<div style="width:' . $width . '"', $view);
    }

    public function testTdWithoutWidth(): void
    {
        $view = TD::set('name')->buildTd(new Repository(['name' => 'value']));

        $this->assertStringNotContainsString('div style="width:"', $view);
    }
}
