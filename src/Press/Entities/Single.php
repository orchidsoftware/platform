<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\DateTimer;
use Illuminate\Contracts\Routing\UrlRoutable;

abstract class Single implements EntityContract, UrlRoutable
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
            DateTimer::make('publish_at')
                ->title(__('Time of Publication')),

            Select::make('status')
                ->options($this->status())
                ->title(__('Status')),
        ];
    }
}
