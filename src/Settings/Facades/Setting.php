<?php

namespace Orchid\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Settings\Models\Setting as SettingModel;

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
