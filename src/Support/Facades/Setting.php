<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Setting\Setting as SettingModel;

/**
 * Class Setting.
 *
 * @method static Setting set(string $name, string | array $value)
 * @method static Setting get(string $name, string | null $default)
 * @method static Setting forget(string $name)
 * @method static Setting getNoCache(string $name, string | null $default)
 */
class Setting extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return Dashboard::modelClass(SettingModel::class);
    }
}
