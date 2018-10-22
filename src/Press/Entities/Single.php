<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Orchid\Screen\Field;

abstract class Single
{
    use Structure, Actions;

    /**
     * Registered fields for main.
     *
     * @return array
     * @throws \Throwable
     */
    public function main(): array
    {
        return [
            Field::tag('datetime')
                ->name('publish_at')
                ->title(__('Time of Publication')),

            Field::tag('select')
                ->options($this->status())
                ->name('status')
                ->title(__('Status')),
        ];
    }
}
