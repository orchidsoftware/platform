<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\DateRange;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class DateRangeTest.
 */
class DateRangeTest extends TestFieldsUnitCase
{
    public function test_instance(): void
    {
        $field = DateRange::make('date');

        $view = self::renderField($field);

        $this->assertStringContainsString('name="date[start]"', $view);
        $this->assertStringContainsString('name="date[end]"', $view);
    }

    public function test_value_instance(): void
    {
        $start = now()->subMonth();
        $end = now();

        $field = DateRange::make('date')
            ->value([
                'start' => $start,
                'end'   => $end,
            ]);

        $view = self::renderField($field);

        $this->assertStringContainsString(sprintf('value="%s"', $start->toDateTimeString()), $view);
        $this->assertStringContainsString(sprintf('value="%s"', $end->toDateTimeString()), $view);
    }
}
