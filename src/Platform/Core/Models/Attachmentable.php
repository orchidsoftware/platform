<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Attachmentable extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'attachmentable';
}
