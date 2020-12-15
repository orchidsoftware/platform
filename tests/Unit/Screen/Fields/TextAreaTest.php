<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\TextArea;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class TextAreaTest.
 */
class TextAreaTest extends TestFieldsUnitCase
{
    public function testInstance(): void
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

    public function testNeedRequire(): void
    {
        $textArea = TextArea::make('about')
            ->required();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('required', $view);
    }

    public function testSetRows(): void
    {
        $textArea = TextArea::make('about')
            ->rows(10);

        $view = self::renderField($textArea);

        $this->assertStringContainsString('rows="10"', $view);
    }

    public function testPlaceHolder(): void
    {
        $textArea = TextArea::make('about')
            ->placeholder('Tell us about yourself');

        $view = self::renderField($textArea);

        $this->assertStringContainsString('Tell us about yourself', $view);
    }

    public function testAutoFocus(): void
    {
        $textArea = TextArea::make('about')
            ->autofocus();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('autofocus', $view);
    }

    public function testAutoComplite(): void
    {
        $textArea = TextArea::make('about')
            ->autocomplete();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('autocomplete', $view);
    }

    public function testOldValue(): void
    {
        $textArea = TextArea::make('about')
            ->value('About Me');

        $oldValue = 'test-old-value';
        $oldName = $textArea->getOldName();

        $this->app['router']->get('TextAreaTestOldValue', [
            'middleware' => 'web',
            'uses' => function () use ($textArea, $oldValue, $oldName) {
                request()->merge([
                    $oldName => $oldValue,
                ])->flash();

                return self::renderField($textArea);
            },
        ]);

        $content = $this
            ->call('GET', 'TextAreaTestOldValue')
            ->content();

        $this->assertStringContainsString($oldValue, $content);
        $this->assertStringNotContainsString('About Me', $content);
    }
}
