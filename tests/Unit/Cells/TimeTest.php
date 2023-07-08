<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Time;
use Orchid\Tests\TestUnitCase;


class TimeTest extends TestUnitCase
{
    public function testRenderTimeComponent(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new Time($time);

        $this->assertEquals('12:34', $component->render());
    }

    public function testRenderTimeWithUnitComponent(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new Time($time, unitPrecision: 'second');

        $this->assertEquals('12:34:56', $component->render());
    }

}
