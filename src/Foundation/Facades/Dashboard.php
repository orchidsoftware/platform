<?php namespace Orchid\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Foundation\Kernel\Dashboard as Dash;
use Orchid\Foundation\Services\Menu\Menu as MenuClass;

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
