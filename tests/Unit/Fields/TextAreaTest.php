<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Fields;

use Orchid\Screen\Fields\TextArea;

/**
 * Class TextAreaTest.
 */
class TextAreaTest extends TestFieldsUnitCase
{
    /**
     * @test
     */
    public function testInstanse()
    {
        $textArea = TextArea::make('about')
      ->title('Title About')
      ->help('Think about what you want to tell')
      ->value('About Me');

        $view = self::renderField($textArea);

        $this->assertStringContainsString('about', $view);
        $this->assertStringContainsString('About Me', $view);
        $this->assertStringContainsString('Title About', $view);
        $this->assertStringContainsString('Think about what you want to tell', $view);
    }

    /**
     * @test
     */
    public function testNeedRequire()
    {
        $textArea = TextArea::make('about')
      ->required();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('required', $view);
    }

    /**
     * @test
     */
    public function testSetRows()
    {
        $textArea = TextArea::make('about')
      ->rows(10);

        $view = self::renderField($textArea);

        $this->assertStringContainsString('rows="10"', $view);
    }

    /**
     * @test
     */
    public function testPlaceHolder()
    {
        $textArea = TextArea::make('about')
      ->placeholder('Tell us about yourself');

        $view = self::renderField($textArea);

        $this->assertStringContainsString('Tell us about yourself', $view);
    }

    public function testAutoFocus()
    {
        $textArea = TextArea::make('about')
      ->autofocus();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('autofocus', $view);
    }

    public function testAutoComplite()
    {
        $textArea = TextArea::make('about')
      ->autocomplete();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('autocomplete', $view);
    }
}
