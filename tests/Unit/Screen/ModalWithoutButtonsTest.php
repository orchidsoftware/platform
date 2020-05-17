<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Layouts\Modal;
use Orchid\Tests\App\Screens\ModalScreenWithoutButtons;
use Orchid\Tests\TestUnitCase;

/**
 * Class ModalTest.
 */
class ModalWithoutButtonsTest extends TestUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testModalScreenRender()
    {
        $screen = new ModalScreenWithoutButtons();
        $html = $screen->view()->withErrors(Validator::make([], []))->render();

        $this->assertStringContainsString($screen->name, $html);
        $this->assertStringContainsString($screen->description, $html);
        $this->assertStringContainsString(ModalScreenWithoutButtons::TITLE_MODAL, $html);

        $this->assertStringNotContainsString(ModalScreenWithoutButtons::APPLY_BUTTON, $html);
        $this->assertStringNotContainsString(ModalScreenWithoutButtons::CLOSE_BUTTON, $html);

        $this->assertStringContainsString(Modal::SIZE_LG, $html);
    }
}
