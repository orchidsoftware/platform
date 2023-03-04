<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class QueryWithDefaultValueScreen extends Screen
{
    /**
     * Query data.
     */
    public function query(User $user = null): array
    {
        return [
            'user' => $user,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Test Query With Default Value Screen';
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
     * @return Layout[]
     */
    public function layout(): array
    {
        return [];
    }
}
