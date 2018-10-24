<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Orchid\Platform\Dashboard;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TermRelationship extends Model
{
    use LogsActivityTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'term_relationships';

    /**
     * @var array
     */
    protected $fillable = [
        'post_id',
        'term_taxonomy_id',
        'term_order',
    ];

    /**
     * @var string
     */
    protected static $logAttributes = ['*'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post() : BelongsTo
    {
        return $this->belongsTo(Dashboard::model(Post::class), 'post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy() : BelongsTo
    {
        return $this->belongsTo(Dashboard::model(Taxonomy::class), 'term_taxonomy_id');
    }
}
