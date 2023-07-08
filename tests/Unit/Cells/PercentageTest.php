<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Percentage;
use Orchid\Tests\TestUnitCase;

class PercentageTest extends TestUnitCase
{
    public function testRenderPercentageComponent(): void
    {
        $value = 0.75;

        $component = new Percentage($value);

        $this->assertEquals('75%', $component->render());
    }

    /**
     * Tests rendering of the percentage component with decimal value.
     */
    public function testRenderPercentageWithDecimalComponent(): void
    {
        $value = 0.7554545465;

        $component = new Percentage($value, decimals: 2);

        $this->assertEquals('75.55%', $component->render());
    }

    /**
     * Tests rendering of the percentage component with integer value.
     */
    public function testRenderPercentageIntComponent(): void
    {
        $value = 1;

        $component = new Percentage($value);

        $this->assertEquals('100%', $component->render());
    }

    /**
     * Tests rendering of the percentage component with value greater than one.
     */
    public function testRenderPercentageMoreThanOneComponent(): void
    {
        $value = 1.25;

        $component = new Percentage($value);

        $this->assertEquals('125%', $component->render());
    }

    /**
     * Tests rendering of the percentage component with value greater than one.
     */
    public function testRenderPercentageZeroComponent(): void
    {
        $value = 0;

        $component = new Percentage($value);

        $this->assertEquals('0%', $component->render());
    }
}
