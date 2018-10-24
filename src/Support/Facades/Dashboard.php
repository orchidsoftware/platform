<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Platform\Dashboard as DashboardKernel;

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
        return DashboardKernel::class;
    }
}
