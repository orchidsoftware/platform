<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

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

    public function testRenderTimeWithUnitComponent(): void
    {
        $time = '2022-01-01 12:34:56';

        $component = new DateTime($time, unitPrecision: 'second');

        $this->assertEquals('2022-01-01 12:34:56', $component->render());
    }
}
