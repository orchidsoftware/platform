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
        $screen = new ModalScreen;
        $html = $screen->view()->withErrors(Validator::make([], []))->render();

        $this->assertStringContainsString($screen->name(), $html);
        $this->assertStringContainsString($screen->description(), $html);

        $this->assertStringContainsString(ModalScreen::TITLE_MODAL, $html);
        $this->assertStringContainsString(ModalScreen::APPLY_BUTTON, $html);
        $this->assertStringContainsString(ModalScreen::CLOSE_BUTTON, $html);

        $this->assertStringContainsString(
            'modal-dialog modal-fullscreen-md-down modal-dialog-scrollable '.Modal::SIZE_LG,
            $html,
        );
        $this->assertStringContainsString('aria-labelledby="screen-modal-title-exampleOneModal"', $html);
        $this->assertStringContainsString('id="screen-modal-title-exampleOneModal"', $html);
        $this->assertStringContainsString('aria-labelledby="confirm-dialog-title"', $html);
        $this->assertStringContainsString('id="confirm-dialog-title"', $html);
        $this->assertStringContainsString('modal fade center-scale', $html);
        $this->assertStringContainsString(
            'modal-dialog '.Modal::SIZE_COMPACT,
            $html,
        );
        $this->assertStringNotContainsString('modal-dialog-centered', $html);
        $this->assertStringNotContainsString('modal-confirm', $html);
        $this->assertStringContainsString('<div class="modal-footer">', $html);
        $this->assertStringNotContainsString('modal-actions-stacked', $html);
        $this->assertStringContainsString('aria-labelledby="notification-modal-title"', $html);
        $this->assertStringContainsString('id="notification-modal-title"', $html);
        $this->assertStringContainsString('id="search-modal"', $html);
        $this->assertStringContainsString('aria-label="Search"', $html);
    }
}
