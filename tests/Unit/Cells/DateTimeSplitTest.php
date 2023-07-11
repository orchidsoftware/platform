<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Carbon\Carbon;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Tests\TestUnitCase;

class DateTimeSplitTest extends TestUnitCase
{
    public function testRenderDateTimeSplitTestComponent(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new DateTimeSplit($time);

        $this->assertEquals('<time class="mb-0 text-capitalize">Jan 1, 2022<span class="text-muted d-block">Sat, 12:34</span></time>', $component->render());
    }


    public function testRenderTimeWithFormatComponent(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new DateTimeSplit($time, upperFormat: 'Y-m-d', lowerFormat: 'H:i:s.uP');

        $this->assertEquals('<time class="mb-0 text-capitalize">2022-01-01<span class="text-muted d-block">12:34:56.000000+00:00</span></time>', $component->render());
    }


    public function testRenderTimeWithTimeZoneComponent(): void
    {
        $time = Carbon::parse('2022-01-01 12:34:56', 'Europe/Moscow');

        $component = new DateTimeSplit($time, lowerFormat: 'H:i:s.uP');

        $this->assertEquals('<time class="mb-0 text-capitalize">Jan 1, 2022<span class="text-muted d-block">12:34:56.000000+03:00</span></time>', $component->render());
    }

}
