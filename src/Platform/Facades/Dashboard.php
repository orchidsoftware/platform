<?php

declare(strict_types=1);

namespace Orchid\Platform\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Platform\Kernel\Dashboard as Dash;

/**
 * Class Dashboard.
 */
class Dashboard extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return Dash::class;
    }
}
