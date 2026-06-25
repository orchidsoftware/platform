<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\DateRange;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class DateRangeTest extends TestFieldsUnitCase
{
    public function testInstance(): void
    {
        $field = DateRange::make('date');

        $view = self::renderField($field);

        $this->assertStringContainsString('name="date[start]"', $view);
        $this->assertStringContainsString('name="date[end]"', $view);
    }

    public function testValueInstance(): void
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

    public function testDisableMobile(): void
    {
        $field = DateRange::make('date')
            ->disableMobile();

        $view = self::renderField($field);

        $this->assertStringContainsString('data-datetime-disable-mobile="true"', $view);
    }

    public function testDisableMobileCanBeReEnabled(): void
    {
        $field = DateRange::make('date')
            ->disableMobile(false);

        $view = self::renderField($field);

        $this->assertStringContainsString('data-datetime-disable-mobile="false"', $view);
    }

    public function testFormat(): void
    {
        $field = DateRange::make('date')
            ->format('d-m-Y');

        $view = self::renderField($field);

        $this->assertStringContainsString('data-datetime-date-format="d-m-Y"', $view);
    }

    public function testServerFormat(): void
    {
        $start = '2024-01-15 10:00:00';
        $end = '2024-02-20 14:30:00';

        $field = DateRange::make('date')
            ->value([
                'start' => $start,
                'end'   => $end,
            ])
            ->serverFormat('Y-m-d');

        $view = self::renderField($field);

        $this->assertStringContainsString('2024-01-15', $view);
        $this->assertStringContainsString('2024-02-20', $view);
    }

    public function testServerFormatUsesDefaultFormat(): void
    {
        $start = '2024-01-15 10:00:00';
        $end = '2024-02-20 14:30:00';

        $field = DateRange::make('date')
            ->format('d/m/Y')
            ->value([
                'start' => $start,
                'end'   => $end,
            ])
            ->serverFormat();

        $view = self::renderField($field);

        $this->assertStringContainsString('15/01/2024', $view);
        $this->assertStringContainsString('20/02/2024', $view);
    }

    public function testServerFormatWithNullValues(): void
    {
        $field = DateRange::make('date')
            ->value([
                'start' => null,
                'end'   => null,
            ])
            ->serverFormat('Y-m-d');

        $view = self::renderField($field);

        $this->assertStringContainsString('name="date[start]"', $view);
        $this->assertStringContainsString('name="date[end]"', $view);
    }
}
