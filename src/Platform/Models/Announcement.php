<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Dashboard;
use Parsedown;

class Announcement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'announcements';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'body',
        'active',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['parsed_body'];

    /**
     * Get the user that created the announcement.
     */
    public function author()
    {
        return $this->belongsTo(Dashboard::model(User::class), 'user_id');
    }

    /**
     * Get the parsed body of the announcement.
     *
     * @return string
     */
    public function getParsedBodyAttribute()
    {
        return (new Parsedown)->text(htmlspecialchars($this->attributes['body']));
    }
}