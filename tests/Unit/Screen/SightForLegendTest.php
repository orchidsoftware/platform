<?php

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Sight;
use Orchid\Tests\TestUnitCase;

class SightForLegendTest extends TestUnitCase
{
    public function testShowPopover(): void
    {
        $popover = 'Vivamus sagittis lacus vel augue laoreet rutrum faucibus.';

        $view = Sight::make('name')->popover($popover)->buildDt();

        $this->assertStringContainsString($popover, $view);
    }
}
