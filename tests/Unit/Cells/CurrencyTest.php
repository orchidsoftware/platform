<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Currency;
use Orchid\Tests\TestUnitCase;

class CurrencyTest extends TestUnitCase
{
    public function test_render_currency_component(): void
    {
        $value = 4;

        $component = new Currency($value);

        $this->assertEquals('4.00', $component->render());
    }

    public function test_render_decimal_component(): void
    {
        $value = 0.75;

        $component = new Currency($value, decimals: 2);

        $this->assertEquals('0.75', $component->render());
    }

    public function test_render_big_currency_component(): void
    {
        $value = 100400500.75;

        $component = new Currency($value);

        $this->assertEquals('100,400,500.75', $component->render());
    }

    public function test_render_big_currency_with_parameter_component(): void
    {
        $value = 100400500.75;

        $component = new Currency($value, decimals: 1, decimal_separator: ',', thousands_separator: ' ');

        $this->assertEquals('100 400 500,8', $component->render());
    }

    public function test_render_big_currency_with_before_text_component(): void
    {
        $value = 100400500.75;

        $component = new Currency($value, before: '$');

        $this->assertEquals('$ 100,400,500.75', $component->render());
    }

    public function test_render_big_currency_with_after_text_component(): void
    {
        $value = 100400500.75;

        $component = new Currency($value, after: '$');

        $this->assertEquals('100,400,500.75 $', $component->render());
    }
}
