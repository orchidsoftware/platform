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
    public function testInstance(): void
    {
        $field = DateTimer::make('date');

        $view = self::renderField($field);

        $this->assertStringContainsString('name="date"', $view);
    }

    public function testValueInstance(): void
    {
        $start = now();

        $field = DateTimer::make('date')->value($start);

        $view = self::renderField($field);

        $this->assertStringContainsString(sprintf('value="%s"', $start->toDateTimeString()), $view);
    }

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

    public function testEnableTimeAndFormat24hr()
    {
        $field = DateTimer::make('date')
            ->format('Y-m-d H:i:s')
            ->enableTime()
            ->format24hr();

        $view = self::renderField($field);

        $this->assertStringContainsString('data-datetime-time_24hr="true"', $view);
    }

    public function testWithQuickDates(): void
    {
        $field = DateTimer::make('date')
            ->format('Y-m-d H:i')
            ->enableTime()
            ->format24hr()
            ->range()
            ->withQuickDates([
                'Today'     => Carbon::parse('2024-03-19 12:11:11'),
                'Yesterday' => Carbon::parse('2024-03-18 12:11:11')->subDay(),
                'Week'      => [
                    Carbon::parse('2024-03-19 12:11:11')->startOfDay()->subWeek(),
                    Carbon::parse('2024-03-19 12:11:11')->endOfDay(),
                ],
            ]);

        $view = self::renderField($field);

        $this->assertStringContainsString('data-value="[&quot;2024-03-17 12:11&quot;]"', $view);
        $this->assertStringContainsString('data-value="[&quot;2024-03-12 00:00&quot;,&quot;2024-03-19 23:59&quot;]"', $view);
    }
}
