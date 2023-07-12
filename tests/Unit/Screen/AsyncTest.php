<?php

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Support\ViewErrorBag;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\App\Layouts\DependentSumListener;
use Orchid\Tests\App\Screens\FindBySlugLayoutScreen;
use Orchid\Tests\TestUnitCase;

class AsyncTest extends TestUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testFindBySlug(): void
    {
        app(\Illuminate\Contracts\View\Factory::class)->share('errors', new ViewErrorBag);

        /** @var Screen $screen */
        $screen = app(FindBySlugLayoutScreen::class);

        collect([
            new DependentSumListener('simple'),
            new DependentSumListener('columns-1'),
            new DependentSumListener('columns-2'),
            new DependentSumListener('tab-1'),
            new DependentSumListener('tab-2'),
        ])
            ->map(fn (Listener $listener) => $listener->getSlug())
            ->map(fn (string $slug) => $screen->asyncBuild('asyncStub', $slug))
            ->each(fn ($layout) => $this->assertNotNull($layout));
    }

    public function testSlugLayout(): void
    {
        $first = new DependentSumListener('modal-1');
        $second = new DependentSumListener('modal-2');

        $this->assertNotEquals($first->getSlug(), $second->getSlug());
    }

    public function testAnonymousClass(): void
    {
        $first = new DependentSumListener('modal-1');
        $second = new DependentSumListener('modal-2');

        $modalFirst = Layout::modal('modal-1', $first);
        $modalSecond = Layout::modal('modal-2', $second);

        // Each modal should have a unique slug
        $this->assertNotNull($modalFirst->findBySlug($first->getSlug()));
        $this->assertNotNull($modalSecond->findBySlug($second->getSlug()));

        // Modal should not have a slug of another modal
        $this->assertNull(Layout::modal('modal-1', $first)->findBySlug($second->getSlug()));
    }
}
