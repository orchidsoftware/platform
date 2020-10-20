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
        $hr = '<div class="line line-dashed border-bottom my-3"></div>';

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

    public function testDataAttributes(): void
    {
        $input = (string) Input::make('name')
            ->set('data-name', 'Alexandr Chernyaev')
            ->set('data-location', 'Russia')
            ->set('data-hello', 'world!');

        $this->assertStringContainsString('data-name="Alexandr Chernyaev"', $input);
        $this->assertStringContainsString('data-location="Russia"', $input);
        $this->assertStringContainsString('data-hello="world!"', $input);
    }

    public function testEscapeAttributes(): void
    {
        $input = (string) Input::make('name')->value('valueQuote"');

        $this->assertStringContainsString('value="valueQuote&quot;"', $input);
    }

    public function testRemoveBooleanAttributes(): void
    {
        $input = (string) Input::make('name')->required(false);

        $this->assertStringNotContainsString('required', $input);
    }
}
