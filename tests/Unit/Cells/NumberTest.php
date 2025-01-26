<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Number;
use Orchid\Tests\TestUnitCase;

class NumberTest extends TestUnitCase
{
    public function test_render_number_component(): void
    {
        $value = 4;

        $component = new Number($value);

        $this->assertEquals('4', $component->render());
    }

    public function test_render_decimal_component(): void
    {
        $value = 0.75;

        $component = new Number($value, decimals: 2);

        $this->assertEquals('0.75', $component->render());
    }

    public function test_render_big_number_component(): void
    {
        $value = 100400500.75;

        $component = new Number($value);

        $this->assertEquals('100,400,501', $component->render());
    }

    public function test_render_big_number_with_parameter_component(): void
    {
        $value = 100400500.75;

        $component = new Number($value, decimals: 1, decimal_separator: ',', thousands_separator: ' ');

        $this->assertEquals('100 400 500,8', $component->render());
    }
}
