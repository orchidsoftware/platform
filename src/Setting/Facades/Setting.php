<?php

namespace Orchid\Setting\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Setting\Models\Setting as SettingModel;

class Setting extends Facade
{
    /**
     * Model of Setting.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return SettingModel::class;
    }
}
