<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Core\Builders\TaxonomyBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Taxonomy extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'term_taxonomy';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'term_id',
        'taxonomy',
        'parent_id',
    ];

    /**
     * @var array
     */
    protected $with = [
        'term',
    ];

    /**
     * Magic method to return the meta data like the post original fields.
     *
     * @param string $key
     *
     * @return string|object
     */
    public function __get($key)
    {
        if (! isset($this->$key)) {
            if (isset($this->term->$key)) {
                return $this->term->$key;
            }
        }

        return parent::__get($key);
    }

    /**
     * Relationship with Term model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function term() : BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    /**
     * Relationship with parent Term model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentTerm() : BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return mixed
     */
    public function allChildrenTerm()
    {
        return $this->childrenTerm()->with('childrenTerm');
    }

    /**
     * Relationship with children Term model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenTerm() : HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Relationship with Posts model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts() : BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'term_relationships', 'term_taxonomy_id', 'post_id');
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return TaxonomyBuilder
     */
    public function newEloquentBuilder($query)
    {
        $builder = new TaxonomyBuilder($query);

        return isset($this->taxonomy) && $this->taxonomy ? $builder->where('taxonomy', $this->taxonomy) : $builder;
    }
}
