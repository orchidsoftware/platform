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
class ModalWithoutButtonTest extends TestUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testModalScreenRender()
    {
        $screen = new ModalScreenWithoutButtons();
        $html = $screen->view()->withErrors(Validator::make([], []))->render();

        $this->assertStringNotContainsString($screen->name, $html);
        $this->assertStringNotContainsString($screen->description, $html);

        $this->assertStringNotContainsString(ModalScreenWithoutButtons::TITLE_MODAL, $html);
        $this->assertStringNotContainsString(ModalScreenWithoutButtons::APPLY_BUTTON, $html);
        $this->assertStringNotContainsString(ModalScreenWithoutButtons::CLOSE_BUTTON, $html);

        $this->assertStringNotContainsString(Modal::SIZE_LG, $html);
    }
}
