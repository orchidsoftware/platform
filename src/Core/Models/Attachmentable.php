<?php

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Attachmentable extends Model
{

    /**
     * @var string
     */
    protected $table = 'attachmentable';

    /**
     * @var bool
     */
    public $timestamps = false;
}
