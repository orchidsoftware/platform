<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Adv extends Model
{
    /**
     * @var string
     */
    protected $table = 'ads';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'content',
        'file_name',
    ];

    protected $casts = [
        'content'   => 'array',
        'file_name' => 'string',
    ];
}
