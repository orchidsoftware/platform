<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Core\Traits\SettingTrait;

class Setting extends Model
{
    use SettingTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Cache result.
     *
     * @var bool
     */
    public $cache = true;

    /**
     * @var string
     */
    protected $table = 'settings';

    /**
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'value' => 'array',
    ];
}
