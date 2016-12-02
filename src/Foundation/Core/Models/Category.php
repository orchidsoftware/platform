<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var string
     */
    protected $table = 'category';

    /**
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];
}
