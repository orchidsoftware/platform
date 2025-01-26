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
    public function test_modal_toggle_instance(): void
    {
        $modalToggle = ModalToggle::make('About');
        $view = self::renderField($modalToggle);

        $this->assertStringContainsString('About', $view);
    }

    public function test_modal_toggle_title(): void
    {
        $modalToggle = ModalToggle::make('About')
            ->title('Title for modal');

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString('Title for modal', $view);
    }

    public function test_modal_toggle_modal_key(): void
    {
        $modalToggle = ModalToggle::make('About')
            ->modal('KeyForModal')
            ->method('method');

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString(
            'data-modal-toggle-key="KeyForModal"',
            $view
        );

        $this->assertStringContainsString(
            'data-modal-toggle-action="http://127.0.0.1:8001/method',
            $view
        );
    }

    public function test_modal_toggle_modal_params(): void
    {
        $modalToggle = ModalToggle::make('About')
            ->modal('KeyForModal')
            ->method('method')
            ->parameters([
                'name' => 'Alexandr',
            ]);

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString(
            'data-modal-toggle-action="http://127.0.0.1:8001/method?name=Alexandr',
            $view
        );
    }
}
