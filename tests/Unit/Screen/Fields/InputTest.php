<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Session\Store;
use Orchid\Screen\Fields\Input;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;
use Throwable;

class InputTest extends TestFieldsUnitCase
{
    use InteractsWithSession;

    /**
     * @throws Throwable
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

    public function testDataListAttribute(): void
    {
        $input = (string) Input::make('browser')->datalist([
            'Opera', 'Edge', 'Firefox',
            'Chrome', 'Safari',
        ]);

        $this->assertStringContainsString('Safari', $input);
        $this->assertStringContainsString('list="datalist-browser"', $input);
        $this->assertStringContainsString('<datalist id="datalist-browser"', $input);

        $input = (string) Input::make('browser')->datalist([]);

        $this->assertStringNotContainsString('list="datalist-browser"', $input);
        $this->assertStringNotContainsString('<datalist id="datalist-browser"', $input);
    }

    public function testWithoutFormType()
    {
        $input = Input::make('inputFieldName')
            ->title('Lorem ipsum dolor sit amet')
            ->withoutFormType();

        $this->assertStringContainsString('Lorem ipsum dolor sit amet', self::renderField($input));
        $this->assertStringNotContainsString('</label>', self::renderField($input));
    }

    public function testAddMinLengthAttribute(): void
    {
        $input = (string) Input::make('name')->minlength(3);

        $this->assertStringContainsString('minlength="3"', $input);
    }

    public function testLongNumericValue(): void
    {
        $session = tap(app()->make(Store::class), function ($session) {
            $session->start();
            $session->put('_old_input', [
                'numeric' => '1234567890123456789012345678901234567890',
            ]);
        });

        request()->setLaravelSession($session);

        $input = Input::make('numeric')->getOldValue();

        $this->assertEquals('1234567890123456789012345678901234567890', $input);
    }

    public function testMediumLongNumericValue(): void
    {
        $session = tap(app()->make(Store::class), function ($session) {
            $session->start();
            $session->put('_old_input', [
                'numeric' => '66666666666666666666',
            ]);
        });

        request()->setLaravelSession($session);

        $input = Input::make('numeric')->getOldValue();

        $this->assertEquals('66666666666666666666', $input);
    }

    public function testOverwriteAttributes(): void
    {
        $input = Input::make()
            ->set('title', 'John Doe')
            ->set('title', null);

        $this->assertNull($input->get('title'));
    }
}
