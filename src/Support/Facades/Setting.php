<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Setting\Setting as SettingModel;

class Setting extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return SettingModel::class;
    }
}
