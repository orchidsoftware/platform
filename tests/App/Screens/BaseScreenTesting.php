<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BaseScreenTesting extends Screen
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
        return 'Base Screen Test';
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
        return [
            Layout::rows([
                Input::make('user.name')->title('Name'),
                Input::make('user.email')->title('Email'),
            ]),
        ];
    }

    public function showToast(Request $request): void
    {
        Toast::warning($request->get('toast', 'Hello, world! This is a toast message.'));
    }

    /**
     * @return string
     */
    public function getUser(Request $request)
    {
        return $request->user()->toJson();
    }
}
