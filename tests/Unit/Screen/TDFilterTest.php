<?php

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;
use Orchid\Tests\TestUnitCase;

class TDFilterTest extends TestUnitCase
{
    public function test_td_simple_filter(): void
    {
        request()->replace([
            'filter' => ['name' => 'username'],
        ]);

        $view = TD::make('name')
            ->filter()
            ->buildTh();

        $this->assertStringContainsString('username', $view);
    }

    public function test_td_simple_filter_callable_value_argument(): void
    {
        request()->replace([
            'filter' => ['number' => 2022],
        ]);

        $view = TD::make('number')
            ->filter(Input::make(), fn (string $value): string => $value * 2)
            ->buildTh();

        $this->assertStringContainsString('4044', $view);
    }

    public function test_td_simple_filter_callable_value_method(): void
    {
        request()->replace([
            'filter' => ['number' => 2022],
        ]);

        $view = TD::make('number')
            ->filter()
            ->filterValue(fn (string $value): string => $value * 2)
            ->buildTh();

        $this->assertStringContainsString('4044', $view);
    }

    public function test_td_empty_filter_with_callable_value(): void
    {
        request()->replace([
            'filter' => null,
        ]);

        $view = TD::make()
            ->filter()
            ->filterValue(fn (string $value): string => $value * 2)
            ->buildTh();

        $this->assertNotNull($view);
    }
}
