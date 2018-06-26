<?php

declare(strict_types=1);

namespace Orchid\Attachment\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attachmentable.
 */
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
