<?php

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Screen;
use Orchid\Tests\App\Screens\FindBySlugLayoutScreen;
use Orchid\Tests\TestUnitCase;

class AsyncTest extends TestUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testFindBySlug(): void
    {
        /** @var Screen $screen */
        $screen = app(FindBySlugLayoutScreen::class);

        collect([
            'simple',
            'columns-1',
            'columns-2',
            'tab-1',
            'tab-2',
        ])
            ->map(fn (string $slug) => $screen->asyncBuild('asyncStub', $slug))
            ->each(fn ($layout) => $this->assertNotNull($layout));
    }
}
