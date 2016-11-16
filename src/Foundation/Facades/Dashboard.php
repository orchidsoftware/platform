<?php

namespace Orchid\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Foundation\Kernel\Dashboard as Dash;

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
