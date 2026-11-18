<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Actions;

use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class ModalToggle.
 */
class ModalToggleTest extends TestFieldsUnitCase
{
    public function testModalToggleInstance(): void
    {
        $modalToggle = ModalToggle::make('About');
        $view = self::renderField($modalToggle);

        $this->assertStringContainsString('About', $view);
    }

    public function testModalToggleTitle(): void
    {
        $modalToggle = ModalToggle::make('About')
            ->title('Title for modal');

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString('Title for modal', $view);
    }

    public function testModalToggleModalKey(): void
    {
        $modalToggle = ModalToggle::make('About')
            ->modal('KeyForModal')
            ->method('method');

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString(
            'data-modal-toggle-key-value="KeyForModal"',
            $view
        );

        $this->assertStringContainsString(
            'data-modal-toggle-action-value="http://127.0.0.1:8001/method',
            $view
        );
    }

    public function testAsyncParametersRenderOnlyModelRouteKeysAndPreservePlainValues(): void
    {
        $user = new class extends User
        {
            public function getRouteKeyName(): string
            {
                return 'slug';
            }
        };
        $user->forceFill(['id' => 42, 'slug' => 'editor', 'name' => 'Private name']);

        $view = self::renderField(ModalToggle::make('Edit')->asyncParameters([
            'user'     => $user,
            'filters'  => ['owners' => [$user], 'page' => 0],
            'search'   => '',
            'selected' => [],
        ]));

        $this->assertStringContainsString(
            'data-modal-toggle-parameters-value=\'{"user":"editor","filters":{"owners":["editor"],"page":0},"search":"","selected":[]}\'',
            $view
        );
    }
}
