<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Actions\Button;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class ButtonTest.
 */
class ButtonTest extends TestFieldsUnitCase
{
    /**
     */
    public function testButtonInstance()
    {
        $button = Button::make('About')
            ->method('test');
        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8000/test?',
            $view
        );
    }

    /**
     */
    public function testButtonParams()
    {
        $button = Button::make('About')
            ->method('test')
            ->parameters([
                'name' => 'Alexandr',
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8000/test?name=Alexandr',
            $view
        );
    }

    /**
     */
    public function testButtonTitle()
    {
        $button = Button::make('About')
            ->method('test')
            ->title('Submit form');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'Submit form',
            $view
        );
    }

    /**
     */
    public function testButtonDisableTurbolinks()
    {
        $button = Button::make('About')
            ->method('test')
            ->rawClick();

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'data-turbolinks="false"',
            $view
        );
    }

    /**
     */
    public function testButtonEnabledTurbolinks()
    {
        $button = Button::make('About')
            ->method('test')
            ->rawClick(true);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'data-turbolinks="true"',
            $view
        );
    }
}
