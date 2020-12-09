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
    public function testButtonInstance(): void
    {
        $button = Button::make('About')
            ->method('test');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test',
            $view
        );
    }

    public function testButtonParams(): void
    {
        $button = Button::make('About')
            ->method('test')
            ->parameters([
                'name' => 'Alexandr',
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test?name=Alexandr',
            $view
        );
    }

    public function testButtonTitle(): void
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

    public function testButtonDisableTurbolinks(): void
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

    public function testButtonEnabledTurbolinks(): void
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

    public function testButtonForCustomAction(): void
    {
        $buttonForRoute = Button::make('About')
            ->action(route('platform.systems.index'));

        $view = self::renderField($buttonForRoute);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/dashboard/systems"',
            $view
        );

        $buttonForLink = Button::make('Example')
            ->action('http://example.com');

        $view = self::renderField($buttonForLink);

        $this->assertStringContainsString(
            'formaction="http://example.com"',
            $view
        );
    }

    public function testButtonWhenDisable()
    {
        $button = Button::make('About')
            ->method('test')
            ->when(true, function (Button $button) {
                $button->disabled(true);
            });

        $view = self::renderField($button);

        $this->assertStringContainsString('disabled', $view);

        $button = Button::make('About')
            ->method('test')
            ->when(false, function (Button $button) {
                $button->disabled(true);
            });

        $view = self::renderField($button);

        $this->assertStringNotContainsString('disabled', $view);
    }
}
