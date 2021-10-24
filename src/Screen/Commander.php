<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Contracts\Actionable;

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
    protected function buildCommandBar(Repository $repository): array
    {
        return collect($this->commandBar())
            ->map(static function (Actionable $command) use ($repository) {
                return $command->build($repository);
            })->filter()->all();
    }
}
