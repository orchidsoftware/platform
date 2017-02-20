<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Adv extends Model
{
    /**
     * @var string
     */
    protected $table = 'adv';

    /**
     * @var array
     */
    protected $fillable = [
        'content',
        'file_name'
    ];
}
