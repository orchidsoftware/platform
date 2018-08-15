<?php

declare(strict_types=1);

namespace Orchid\Attachment\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Attachmentable.
 */
class Attachmentable extends Model
{
    use LogsActivity;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'attachmentable';

    /**
     * @var string
     */
    protected static $logAttributes = ['*'];
}
