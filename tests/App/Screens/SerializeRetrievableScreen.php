<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Foundation\Application;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

/**
 * A simple value object used to test that arbitrary non-Model, non-Closure
 * objects are serialized through PHP native serialization (not ModelIdentifier).
 */
class ValueObject
{
    public function __construct(
        public readonly string $label,
        public readonly int $count,
    ) {}
}

class SerializeRetrievableScreen extends Screen
{
    public $public = 'Public';

    public $callback = null;

    public array $data = [];

    public float $amount = 0.0;

    public ?ValueObject $valueObject = null;

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
