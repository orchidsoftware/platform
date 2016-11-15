<?php namespace Orchid\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Foundation\Services\Alert\Alert as AlertModel;

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
