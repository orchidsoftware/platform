<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Tests\App\Layouts\DependentSumListener;

class DependentListenerScreen extends Screen
{
    /**
     * Query data.
     */
    public function query(): array
    {
        return [
            'first' => 100,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Test Dependent';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            DependentSumListener::class,
        ];
    }
}
