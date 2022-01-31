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
    public function testInstance(): void
    {
        $field = DateRange::make('date');

        $view = self::renderField($field);

        $this->assertStringContainsString('name="date[min]"', $view);
        $this->assertStringContainsString('name="date[max]"', $view);
    }

    public function testValueInstance(): void
    {
        $min = now()->subMonth();
        $max = now();

        $field = DateRange::make('date')
            ->value([
                'min' => $min,
                'max'   => $max,
            ]);

        $view = self::renderField($field);

        $this->assertStringContainsString(sprintf('value="%s"', $min->toDateTimeString()), $view);
        $this->assertStringContainsString(sprintf('value="%s"', $max->toDateTimeString()), $view);
    }
}
