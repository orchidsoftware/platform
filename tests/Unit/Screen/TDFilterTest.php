<?php

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;
use Orchid\Tests\TestUnitCase;

class TDFilterTest extends TestUnitCase
{
    public function testTdSimpleFilter(): void
    {
        request()->replace([
            'filter' => ['name' => 'username'],
        ]);

        $view = TD::make('name')
            ->filter()
            ->buildTh();

        $this->assertStringContainsString('username', $view);
    }

    public function testTdSimpleFilterCallableValueArgument(): void
    {
        request()->replace([
            'filter' => ['number' => 2022],
        ]);

        $view = TD::make('number')
            ->filter(Input::make(), fn(?string $value): string => $value * 2)
            ->buildTh();

        $this->assertStringContainsString('4044', $view);
    }

    public function testTdSimpleFilterCallableValueMethod(): void
    {
        request()->replace([
            'filter' => ['number' => 2022],
        ]);

        $view = TD::make('number')
            ->filter()
            ->filterValue(fn(?string $value): string => $value * 2)
            ->buildTh();

        $this->assertStringContainsString('4044', $view);
    }
}
