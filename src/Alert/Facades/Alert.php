<?php

namespace Orchid\Alert\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Alert\Alert as AlertModel;

class Alert extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return AlertModel::class;
    }
}
