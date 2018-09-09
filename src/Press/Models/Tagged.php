<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Illuminate\Database\Eloquent\Model;

class Tagged extends Model
{
    /**
     * @var string
     */
    protected $table = 'tagged';

    /**
     * @var bool
     */
    public $timestamps = false;
}
