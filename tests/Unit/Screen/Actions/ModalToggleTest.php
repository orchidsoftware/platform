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
    public function testModalToggleInstance()
    {
        $modalToggle = ModalToggle::make('About');
        $view = self::renderField($modalToggle);

        $this->assertStringContainsString('About', $view);
    }

    public function testModalToggleTitle()
    {
        $modalToggle = ModalToggle::make('About')
            ->title('Title for modal');

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString('Title for modal', $view);
    }

    public function testModalToggleModalKey()
    {
        $modalToggle = ModalToggle::make('About')
            ->modal('KeyForModal')
            ->method('method');

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString(
            'data-modal-key="KeyForModal"',
            $view
        );

        $this->assertStringContainsString(
            'data-modal-action="http://127.0.0.1:8000/method',
            $view
        );
    }

    public function testModalToggleModalParams()
    {
        $modalToggle = ModalToggle::make('About')
            ->modal('KeyForModal')
            ->method('method')
            ->parameters([
                'name' => 'Alexandr',
            ]);

        $view = self::renderField($modalToggle);

        $this->assertStringContainsString(
            'data-modal-action="http://127.0.0.1:8000/method?name=Alexandr',
            $view
        );
    }
}
