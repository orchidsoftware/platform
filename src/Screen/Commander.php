<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Contracts\ActionContract;

trait Commander
{
    /**
     * @return Action[]
     */
    protected function commandBar(): array
    {
        return [];
    }

    /**
     * @param Repository $repository
     *
     * @return array
     */
    private function buildCommandBar(Repository $repository): array
    {
        return collect($this->commandBar())
            ->map(function (ActionContract $command) use ($repository) {
                return $command->build($repository);
            })->all();
    }
}
