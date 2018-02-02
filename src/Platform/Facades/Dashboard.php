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
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return Dash::class;
    }
}
