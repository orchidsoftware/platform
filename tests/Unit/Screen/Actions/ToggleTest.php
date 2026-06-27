<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Actions;

use Orchid\Screen\Actions\Toggle;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class ToggleTest extends TestFieldsUnitCase
{
    public function testToggleInstance(): void
    {
        $toggle = Toggle::make('Enable notifications')
            ->name('notifications');

        $view = self::renderField($toggle);

        $this->assertStringContainsString('type="checkbox"', $view);
        $this->assertStringContainsString('class="form-check-input"', $view);
        $this->assertStringContainsString('notifications', $view);
    }

    public function testToggleDisabled(): void
    {
        $toggle = Toggle::make('Disable')
            ->name('disable')
            ->disabled(true);

        $view = self::renderField($toggle);

        $this->assertStringContainsString('disabled', $view);
    }

    public function testToggleMethod(): void
    {
        $toggle = Toggle::make('Update')
            ->name('update')
            ->method('updateStatus');

        $view = self::renderField($toggle);

        $this->assertStringContainsString('formaction="http://127.0.0.1:8001/updateStatus', $view);
    }

    public function testToggleRawClick(): void
    {
        $toggle = Toggle::make('Raw')
            ->name('raw')
            ->method('test')
            ->rawClick();

        $view = self::renderField($toggle);

        $this->assertStringContainsString('data-turbo="false"', $view);
    }

    public function testToggleAction(): void
    {
        $toggle = Toggle::make('Action')
            ->name('action')
            ->action('http://example.com');

        $view = self::renderField($toggle);

        $this->assertStringContainsString('formaction="http://example.com"', $view);
    }

    public function testToggleNotDisplayed(): void
    {
        $toggle = Toggle::make('Hidden')
            ->name('hidden')
            ->canSee(false);

        $this->assertNull($toggle->render());
    }
}
