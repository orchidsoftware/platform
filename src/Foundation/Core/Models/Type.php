<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * @var string
     */
    protected $table = 'type';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];
}
