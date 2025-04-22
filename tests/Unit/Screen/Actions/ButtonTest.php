<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Platform\Models\User;
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

    public function testButtonWithNullParameters(): void
    {
        $button = Button::make('About')
            ->method('test', [
                'id'   => null,
                'name' => 'Alexandr',
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test?name=Alexandr',
            $view
        );
    }

    public function testButtonWithZeroParameters(): void
    {
        $button = Button::make('About')
            ->method('test', [
                'value' => 0,
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test?value=0',
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
            'data-turbo="false"',
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
            'data-turbo="true"',
            $view
        );
    }

    public function testButtonForCustomAction(): void
    {
        $buttonForRoute = Button::make('About')
            ->action(route('platform.index'));

        $view = self::renderField($buttonForRoute);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/dashboard"',
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

    public function testButtonMethodParameters(): void
    {
        $button = Button::make('About')
            ->method('test', [
                'id' => 1,
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test?id=1',
            $view
        );
    }

    public function testButtonMethodParametersOverwrite(): void
    {
        $button = Button::make('About')
            ->parameters([
                'id' => 1,
            ])
            ->method('test');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test?id=1',
            $view
        );
    }

    public function testButtonMethodParametersAcceptsEloquentModel(): void
    {
        $user = User::factory()->create();

        $button = Button::make('About')
            ->parameters([
                'user' => $user,
            ])
            ->method('test');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test?user='.$user->getKey(),
            $view
        );
    }
}
