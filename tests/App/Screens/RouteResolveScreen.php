<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Tests\App\RouteSolving;

class RouteResolveScreen extends Screen
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
        return 'Route Resolve Screen';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Test screen';
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
     * @return Route|object|string|null
     */
    public function resolveModel(RouteSolving $resolve, Request $request)
    {
        return $request->route('resolve');
    }
}
