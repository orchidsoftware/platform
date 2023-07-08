<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Currency;
use Orchid\Tests\TestUnitCase;

class CurrencyTest extends TestUnitCase {

    public function testRenderCurrencyComponent(): void
    {
        $value = 4;

        $component = new Currency($value);

        $this->assertEquals('4.00', $component->render());
    }

    public function testRenderDecimalComponent(): void
    {
        $value = 0.75;

        $component = new Currency($value, decimals: 2);

        $this->assertEquals('0.75', $component->render());
    }

    public function testRenderBigCurrencyComponent(): void
    {
        $value = 100400500.75;

        $component = new Currency($value);

        $this->assertEquals('100,400,500.75', $component->render());
    }

    public function testRenderBigCurrencyWithParameterComponent(): void
    {
        $value = 100400500.75;

        $component = new Currency($value, decimals: 1, decimal_separator: ',', thousands_separator: ' ');

        $this->assertEquals('100 400 500,8', $component->render());
    }

    public function testRenderBigCurrencyWithBeforeTextComponent(): void
    {
        $value = 100400500.75;

        $component = new Currency($value, before: '$');

        $this->assertEquals('$ 100,400,500.75', $component->render());
    }

    public function testRenderBigCurrencyWithAfterTextComponent(): void
    {
        $value = 100400500.75;

        $component = new Currency($value, after: '$');

        $this->assertEquals('100,400,500.75 $', $component->render());
    }
}
