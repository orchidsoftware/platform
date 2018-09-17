<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Parsedown;
use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Scope a query to only include active announcements.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Turns off all announcements.
     *
     * @return int
     */
    public static function disableAll()
    {
        return DB::table('announcements')->update(['active' => 0]);
    }
}
