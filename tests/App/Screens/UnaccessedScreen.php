<?php

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Screen;

class UnaccessedScreen extends Screen
{
    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'whose-permission-never-exists'
        ];
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Unaccessed Screen';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function unaccessed(): RedirectResponse
    {
        return redirect('/other-screen');
    }
}
