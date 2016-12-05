<?php

namespace Orchid\Foundation\Facades;

use Orchid\Alert\Alert as AlertModel;
use Illuminate\Support\Facades\Facade;

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
