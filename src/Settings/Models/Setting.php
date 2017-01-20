<?php

namespace Orchid\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use SettingTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

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


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'key';
    }
}
