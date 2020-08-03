<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Layouts\Modal;
use Orchid\Tests\App\Screens\ModalScreen;
use Orchid\Tests\TestUnitCase;

/**
 * Class ModalTest.
 */
class ModalTest extends TestUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testModalScreenRender(): void
    {
        $screen = new ModalScreen();
        $html = $screen->view()->withErrors(Validator::make([], []))->render();

        $this->assertStringContainsString($screen->name, $html);
        $this->assertStringContainsString($screen->description, $html);

        $this->assertStringContainsString(ModalScreen::TITLE_MODAL, $html);
        $this->assertStringContainsString(ModalScreen::APPLY_BUTTON, $html);
        $this->assertStringContainsString(ModalScreen::CLOSE_BUTTON, $html);

        $this->assertStringContainsString(Modal::SIZE_LG, $html);
    }
}
