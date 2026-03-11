<?php

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class UnaccessedScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'whose-permission-never-exists',
        ];
    }

    /**
     * Query data.
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Unaccessed Screen';
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

    public static function unaccessed(): RedirectResponse
    {
        return redirect('/other-screen');
    }
}
