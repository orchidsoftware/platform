<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TermRelationship extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy() : BelongsTo
    {
        return $this->belongsTo(Taxonomy::class, 'term_taxonomy_id');
    }
}
