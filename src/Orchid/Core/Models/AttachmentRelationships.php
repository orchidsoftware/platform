<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;

class AttachmentRelationships extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'attachment_relationships';
}
