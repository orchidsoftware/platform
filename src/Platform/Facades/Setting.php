<?php

declare(strict_types=1);

namespace Orchid\Platform\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Platform\Core\Models\Setting as SettingModel;

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
