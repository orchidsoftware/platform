<?php

namespace Orchid\Tests\Unit\Screen;

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
}
