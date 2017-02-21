<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Foundation\Core\Builders\TermTaxonomyBuilder;

class TermTaxonomy extends Model
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
     * @return string
     */
    public function __get($key)
    {
        if (!isset($this->$key)) {
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
    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    /**
     * Relationship with parent Term model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentTerm()
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
    public function childrenTerm()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Relationship with Posts model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'term_relationships', 'term_taxonomy_id', 'post_id');
    }

    /**
     * Overriding newQuery() to the custom TermTaxonomyBuilder with some interesting methods.
     *
     * @param bool $excludeDeleted
     *
     * @return TermTaxonomyBuilder
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new TermTaxonomyBuilder($this->newBaseQueryBuilder());
        $builder->setModel($this)->with($this->with);
        if (isset($this->taxonomy) && !empty($this->taxonomy) && !is_null($this->taxonomy)) {
            $builder->where('taxonomy', $this->taxonomy);
        }

        return $builder;
    }
}
