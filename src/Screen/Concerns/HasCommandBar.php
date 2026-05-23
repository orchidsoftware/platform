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

    protected function buildCommandBar(Repository $repository): array
    {
        return collect($this->commandBar())
            ->map(static fn (Actionable $command) => $command->build($repository))
            ->filter()
            ->all();
    }
}
