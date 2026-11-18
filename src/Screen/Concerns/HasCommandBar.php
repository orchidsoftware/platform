<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

use Orchid\Screen\Action;
use Orchid\Screen\Contracts\Actionable;
use Orchid\Screen\Repository;

trait HasCommandBar
{
    /**
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Render visible commands against the supplied repository.
     *
     * @return array<array-key, mixed>
     */
    protected function buildCommandBar(Repository $repository): array
    {
        return collect($this->commandBar())
            ->map(static fn (Actionable $command) => $command->build($repository))
            ->filter()
            ->all();
    }
}
