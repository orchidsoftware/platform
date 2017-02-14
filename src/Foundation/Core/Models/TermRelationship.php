<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(TermTaxonomy::class, 'term_taxonomy_id');
    }
}
