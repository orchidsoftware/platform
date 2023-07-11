<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Carbon\Carbon;
use Orchid\Screen\Components\Cells\DateTime;
use Orchid\Tests\TestUnitCase;

class DateTimeTest extends TestUnitCase
{
    public function testRenderTimeComponent(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new DateTime($time);

        $this->assertEquals('2022-01-01 12:34', $component->render());
    }

    public function testRenderTimeWithFormatComponent(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new DateTime($time, format: 'Y-m-d\TH:i:s.uP');

        $this->assertEquals('2022-01-01T12:34:56.000000+00:00', $component->render());
    }

    public function testRenderTimeWithTimeZoneComponent(): void
    {
        $time = Carbon::parse('2022-01-01 12:34:56', 'Europe/Moscow');

        $component = new DateTime($time, format: 'Y-m-d\TH:i:s.uP', tz: 'Europe/London');

        $this->assertEquals('2022-01-01T12:34:56.000000+03:00', $component->render());
    }
}
