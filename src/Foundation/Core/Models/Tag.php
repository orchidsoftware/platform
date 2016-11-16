<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The tagged entities model.
     *
     * @var string
     */
    protected static $taggedModel = Tagged::class;
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    public $table = 'tags';
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'count',
        'namespace',
    ];

    /**
     * Returns the tagged entities model.
     *
     * @return string
     */
    public static function getTaggedModel()
    {
        return static::$taggedModel;
    }

    /**
     * Sets the tagged entities model.
     *
     * @param string $taggedModel
     */
    public static function setTaggedModel($taggedModel)
    {
        static::$taggedModel = $taggedModel;
    }

    /**
     * @throws \Exception
     *
     * @return bool|null
     */
    public function delete()
    {
        if ($this->exists) {
            $this->tagged()->delete();
        }

        return parent::delete();
    }

    /**
     * Returns this tag tagged entities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagged()
    {
        return $this->hasMany(static::$taggedModel);
    }

    /**
     * Returns the polymorphic relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function taggable()
    {
        return $this->morphTo();
    }

    /**
     * Finds a tag by its name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $name
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName(Builder $query, $name)
    {
        return $query->whereName($name);
    }

    /**
     * Finds a tag by its slug.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSlug(Builder $query, $slug)
    {
        return $query->whereSlug($slug);
    }
}
