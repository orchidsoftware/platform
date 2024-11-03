<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

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

    public function testModalToggleModalParams(): void
    {
        $modalToggle = ModalToggle::make('About')
            ->modal('KeyForModal')
            ->method('method')
            ->parameters([
                'name' => 'Alexandr',
            ]);

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString(
            'data-modal-toggle-action-value="http://127.0.0.1:8001/method?name=Alexandr',
            $view
        );
    }
}
