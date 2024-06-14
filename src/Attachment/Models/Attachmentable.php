<?php

declare(strict_types=1);

namespace Orchid\Attachment\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This class represents the relation between attachments and any model that can have them.
 *
 * @property string $attachmentable_type
 * @property int $attachmentable_id
 * @property int $attachment_id
 *
 */
class Attachmentable extends Model
{
    /**
     * Indicates whether the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attachmentable';
}
