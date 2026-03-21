<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class MethodsResponseScreen extends Screen
{
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
        return 'MethodsResponseScreen';
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

    /**
     * @return RedirectResponse
     */
    public function redirect()
    {
        return redirect()->to('#');
    }

    /**
     * @return Application|ResponseFactory|Response
     */
    public function response()
    {
        return response('content', 200);
    }

    /**
     * No return method.
     */
    public function empty(): void
    {
        // do not delete
    }
}
