<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Contracts\Actionable;

trait Commander
{
    /**
     * @return Action[]
     */
    protected function commandBar(): iterable
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
