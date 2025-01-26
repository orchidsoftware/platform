<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Time;
use Orchid\Tests\TestUnitCase;

class TimeTest extends TestUnitCase
{
    public function test_render_time_component(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new Time($time);

        $this->assertEquals('12:34', $component->render());
    }

    public function test_render_time_with_unit_component(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new Time($time, unitPrecision: 'second');

        $this->assertEquals('12:34:56', $component->render());
    }
}
