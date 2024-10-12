<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Foundation\Application;
use Orchid\Screen\Concerns\ModelStateRetrievable;
use Orchid\Screen\Screen;

class SerializeRetrievableScreen extends Screen
{
    use ModelStateRetrievable;

    public $public = 'Public';

    public function __construct(
        protected Application $application,
        private readonly string $private = 'Private',
        public $user = null
    ) {
        $this->middleware(fn ($request, $next) => $next($request));
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
}
