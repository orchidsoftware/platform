<?php

namespace Orchid\Platform\Facades;

use Illuminate\Support\Facades\Facade;

use Orchid\Platform\Alert\Alert as AlertClass;

/**
 * Class Alert
 *
 * @package Orchid\Platform\Facades
 */
class Alert extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return AlertClass::class;
    }
}
