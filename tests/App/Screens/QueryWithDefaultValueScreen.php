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
     * Display header name.
     *
     * @var string
     */
    public $name = 'Test Query With Default Value Screen';

    /**
     * Query data.
     *
     * @param  User|null  $user
     *
     * @return array
     */
    public function query(User $user = null): array
    {
        return [
            'user' => $user,
        ];
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
