<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\TestUnitCase;

class ModalTest extends TestUnitCase
{
    public function testAsyncAutomaticCorrectionMethod(): void
    {
        $layout = Layout::modal('automatic_correction', [])
            ->async('asyncTestMethod');

        $html = $layout
            ->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringNotContainsString('asyncTestMethod', $html);

        $layout = Layout::modal('automatic_correction', [])
            ->async('testMethod');

        $html = $layout
            ->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringNotContainsString('asyncTestMethod', $html);
    }
}
