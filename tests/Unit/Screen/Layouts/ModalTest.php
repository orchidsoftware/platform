<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class ModalTest extends TestUnitCase
{
    public function testAsyncAutomaticCorrectionMethod(): void
    {
        $layout = Modal::make('automatic_correction', [])
            ->async('asyncTestMethod');

        $html = $layout
            ->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringNotContainsString('asyncTestMethod', $html);

        $layout = Modal::make('automatic_correction', [])
            ->async('testMethod');

        $html = $layout
            ->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringNotContainsString('asyncTestMethod', $html);
    }
}
