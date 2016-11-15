<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * @var string
     */
    protected $table = 'notifications';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'url',
        'text',
        'read',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'read' => 'boolean',
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(self::class);
    }
}
