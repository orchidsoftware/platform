<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Foundation\Application;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class SerializeScreen extends Screen
{
    /**
     * @var string
     */
    public $public = 'Public';

    /**
     * @param User|null $user
     */
    public function __construct(
        protected Application $application,
        private readonly string $screenName = 'Route Resolve Screen',
        public $user = null
    ) {
        $this->middleware(fn ($request, $next) => $next($request));
    }

    /**
     * Query data.
     *
     * @return array{}
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
        return $this->screenName;
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
