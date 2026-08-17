<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\Password;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class PasswordTest extends TestFieldsUnitCase
{
    public function testRevealButtonIsVisibleByDefault(): void
    {
        $view = self::minifyRenderField(Password::make('password'));

        $this->assertStringContainsString('data-controller="password"', $view);
        $this->assertStringContainsString('data-action="click->password#change"', $view);
    }

    public function testRevealButtonCanBeHidden(): void
    {
        $view = self::minifyRenderField(
            Password::make('password')->revealable(false)
        );

        $this->assertStringContainsString('type="password"', $view);
        $this->assertStringNotContainsString('data-controller="password"', $view);
        $this->assertStringNotContainsString('data-action="click->password#change"', $view);
    }
}
