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
     * Create a new model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('platform.attachmentableTable');
    }     
}
