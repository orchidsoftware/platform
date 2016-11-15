<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    /**
     * @var string
     */
    protected $table = 'story';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'image',
        'posts_id',
    ];
}
