<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\NumberRange;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class NumberRangeTest.
 */
class NumberRangeTest extends TestFieldsUnitCase
{
    public function testInstance(): void
    {
        $field = NumberRange::make('num');
        
        $view = self::renderField($field);
        
        $this->assertStringContainsString('name="num[min]"', $view);
        $this->assertStringContainsString('name="num[max]"', $view);
    }
    
    public function testValueInstance(): void
    {
        $min = 3.14;
        $max = 42;
        
        $field = NumberRange::make('num')
                            ->value([
                                'min' => $min,
                                'max' => $max,
                            ]);
        
        $view = self::renderField($field);
        
        $this->assertStringContainsString(sprintf('value="%s"', $min), $view);
        $this->assertStringContainsString(sprintf('value="%s"', $max), $view);
    }
}
