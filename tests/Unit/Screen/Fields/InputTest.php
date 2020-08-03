<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\Input;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class InputTest extends TestFieldsUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testShowHr(): void
    {
        $input = Input::make('inputFieldName');
        $hr = '<div class="line line-dashed border-bottom line-lg"></div>';

        $this->assertStringNotContainsString($hr, self::renderField($input));

        $input->hr();

        $this->assertStringContainsString($hr, self::renderField($input));
    }

    public function testArrayMask(): void
    {
        $input = Input::make('price')
            ->mask([
                'alias'          => 'currency',
                'prefix'         => ' ',
                'groupSeparator' => ' ',
                'digitsOptional' => true,
            ]);

        $view = self::minifyRenderField($input);

        $this->assertStringContainsString('currency', $view);
    }

    public function testStringMask(): void
    {
        $input = Input::make('phone')
            ->mask('(999) 999-9999');

        $view = self::minifyRenderField($input);

        $this->assertStringContainsString('(999) 999-9999', $view);
    }

    public function testObjectToSting(): void
    {
        $input = Input::make('name')
            ->title('What is your name?');

        $this->assertStringContainsString('What is your name?', (string) $input);
    }
}
