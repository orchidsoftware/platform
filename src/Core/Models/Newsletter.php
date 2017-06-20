<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    /**
     * @var string
     */
    protected $table = 'newsletter';

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'lang',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'updated_at',
        'created_at',
    ];
}
