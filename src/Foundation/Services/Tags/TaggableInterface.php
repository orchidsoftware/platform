<?php

namespace Orchid\Foundation\Services\Tags;

use Illuminate\Database\Eloquent\Builder;

interface TaggableInterface
{
    /**
     * Returns the tags delimiter.
     *
     * @return string
     */
    public static function getTagsDelimiter();

    /**
     * Sets the tags delimiter.
     *
     * @param string $delimiter
     *
     * @return $this
     */
    public static function setTagsDelimiter($delimiter);

    /**
     * Returns the Eloquent tags model name.
     *
     * @return string
     */
    public static function getTagsModel();

    /**
     * Sets the Eloquent tags model name.
     *
     * @param string $model
     */
    public static function setTagsModel($model);

    /**
     * Returns the slug generator.
     *
     * @return string
     */
    public static function getSlugGenerator();

    /**
     * Sets the slug generator.
     *
     * @param string $name
     */
    public static function setSlugGenerator($name);

    /**
     * Returns all the tags under the entity namespace.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function allTags();

    /**
     * Returns the entities with only the given tags.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array                          $tags
     * @param string                                $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeWhereTag(Builder $query, $tags, $type = 'slug');

    /**
     * Returns the entities with one of the given tags.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array                          $tags
     * @param string                                $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeWithTag(Builder $query, $tags, $type = 'slug');

    /**
     * Creates a new model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createTagsModel();

    /**
     * Returns the entity Eloquent tag model object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags();

    /**
     * Attaches multiple tags to the entity.
     *
     * @param string|array $tags
     *
     * @return bool
     */
    public function tag($tags);

    /**
     * Detaches multiple tags from the entity or if no tags are
     * passed, removes all the attached tags from the entity.
     *
     * @param string|array|null $tags
     *
     * @return bool
     */
    public function untag($tags = null);

    /**
     * Attaches or detaches the given tags.
     *
     * @param string|array $tags
     * @param string       $type
     *
     * @return bool
     */
    public function setTags($tags, $type = 'name');

    /**
     * Attaches the given tag to the entity.
     *
     * @param string $name
     */
    public function addTag($name);

    /**
     * Detaches the given tag from the entity.
     *
     * @param string $name
     */
    public function removeTag($name);

    /**
     * Prepares the given tags before being saved.
     *
     * @param string|array $tags
     *
     * @return array
     */
    public function prepareTags($tags);
}
