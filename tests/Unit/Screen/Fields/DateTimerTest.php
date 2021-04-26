<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Carbon\Carbon;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class DateTimerTest.
 */
class DateTimerTest extends TestFieldsUnitCase
{
    public function testServerFormat(): void
    {
        $value = Carbon::createFromFormat('Y-m-d H:i:s.u', '2021-02-01 03:45:27.612584');

        $field = DateTimer::make('date')
            ->serverFormat('Y-m-d\TH:i:sP')
            ->value($value);

        $view = self::renderField($field);

        $this->assertStringContainsString('value="2021-02-01T03:45:27+00:00"', $view);

        $field = DateTimer::make('date')
            ->format('Y-m-d')
            ->serverFormat()
            ->value($value);

        $view = self::renderField($field);

        $this->assertStringContainsString('value="2021-02-01"', $view);
    }

    public function testWithoutServerFormat(): void
    {
        $value = Carbon::createFromFormat('Y-m-d H:i:s.u', '2021-02-01 03:45:27.612584');

        $field = DateTimer::make('date')
            ->format('Y-m-d')
            ->value($value);

        $view = self::renderField($field);

        $this->assertStringContainsString('value="2021-02-01 03:45:27"', $view);
    }
}
