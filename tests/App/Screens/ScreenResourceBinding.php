<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Tests\App\RouteSolving;

class RouteResolveScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Route Resolve Screen';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Test screen';

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
