<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class QueryWithoutDefaultValueScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Test Query Without Default Value Screen';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(User $user): array
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
