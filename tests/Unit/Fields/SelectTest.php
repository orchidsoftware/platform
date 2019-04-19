<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Fields;

use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;

/**
 * Class SelectTest.
 */
class SelectTest extends TestFieldsUnitCase
{
    /**
     * @test
     */
    public function testInstanse()
    {
        $textArea = Select::make('choice')
            ->title('Title About')
            ->help('Think about what you want to tell')
            ->options([
                'first'  => 'First Value',
                'second' => 'Second Value',
                'third'  => 'Third Value',
            ]);

        $view = self::renderField($textArea);

        $this->assertStringContainsString('First Value', $view);
        $this->assertStringContainsString('Second Value', $view);
        $this->assertStringContainsString('Third Value', $view);

        $this->assertStringContainsString('first', $view);
        $this->assertStringContainsString('second', $view);
        $this->assertStringContainsString('third', $view);

        $this->assertStringContainsString('Title About', $view);
        $this->assertStringContainsString('Think about what you want to tell', $view);
    }

    /**
     * @test
     */
    public function testNeedRequire()
    {
        $textArea = Select::make('choice')
            ->options([])
            ->required();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('required', $view);
    }

    /**
     * @test
     */
    public function testSetValue()
    {
        $textArea = Select::make('choice')
            ->value('second')
            ->options([
                'first'  => 'First Value',
                'second' => 'Second Value',
                'third'  => 'Third Value',
            ]);

        $view = self::renderField($textArea);
        $view = self::minifyOutput($view);

        $this->assertStringContainsString('value="second" selected', $view);
    }

    /**
     * @test
     */
    public function testAutoFocus()
    {
        $textArea = TextArea::make('about')
            ->autofocus();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('autofocus', $view);
    }

    /**
     * @test
     */
    public function testEmptyForArray()
    {
        $textArea = Select::make('choice')
            ->options([
                'first'  => 'First Value',
                'second' => 'Second Value',
                'third'  => 'Third Value',
            ])
            ->empty('empty');

        $view = self::renderField($textArea);
        $view = self::minifyOutput($view);

        $this->assertStringContainsString('<option value="">empty</option>', $view);
    }
}
