<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Tests\App\RouteSolving;

class RouteResolveScreen extends Screen
{
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
        return 'Route Resolve Screen';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Test screen';
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
     * @param RouteSolving $resolve
     * @param Request      $request
     *
     * @return \Illuminate\Routing\Route|object|string|null
     */
    public function resolveModel(RouteSolving $resolve, Request $request)
    {
        return $request->route('resolve');
    }
}
