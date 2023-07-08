<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Number;
use Orchid\Tests\TestUnitCase;

class NumberTest extends TestUnitCase
{

    public function testRenderNumberComponent(): void
    {
        $value = 4;

        $component = new Number($value);

        $this->assertEquals('4', $component->render());
    }

    public function testRenderDecimalComponent(): void
    {
        $value = 0.75;

        $component = new Number($value, decimals: 2);

        $this->assertEquals('0.75', $component->render());
    }

    public function testRenderBigNumberComponent(): void
    {
        $value = 100400500.75;

        $component = new Number($value);

        $this->assertEquals('100,400,501', $component->render());
    }

    public function testRenderBigNumberWithParameterComponent(): void
    {
        $value = 100400500.75;

        $component = new Number($value, decimals: 1, decimal_separator: ',', thousands_separator: ' ');

        $this->assertEquals('100 400 500,8', $component->render());
    }
}
