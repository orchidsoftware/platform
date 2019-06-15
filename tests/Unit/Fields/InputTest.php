<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Fields;

use Orchid\Screen\Fields\Input;

class InputTest extends TestFieldsUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testShowHr()
    {
        $input = Input::make('inputFieldName');
        $hr = '<div class="line line-dashed b-b line-lg"></div>';

        $this->assertStringNotContainsString($hr, self::renderField($input));

        $input->hr();

        $this->assertStringContainsString($hr, self::renderField($input));
    }

    public function testArrayMask()
    {
        $input = Input::make('price')
            ->mask([
                'alias'          => 'currency',
                'prefix'         => ' ',
                'groupSeparator' => ' ',
                'digitsOptional' => true,
            ]);

        $view = self::renderField($input);
        $view = self::minifyOutput($view);

        $this->assertStringContainsString('currency', $view);
    }

    public function testStringMask()
    {
        $input = Input::make('phone')
            ->mask('(999) 999-9999');

        $view = self::renderField($input);
        $view = self::minifyOutput($view);

        $this->assertStringContainsString('(999) 999-9999', $view);
    }
}
