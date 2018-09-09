<?php

declare(strict_types=1);

namespace Orchid\Press\Traits;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Press\Models\Tag;

trait TaggableTrait
{
    /**
     * The tags delimiter.
     *
     * @var string
     */
    protected static $delimiter = ',';

    /**
     * The Eloquent tags model name.
     *
     * @var string
     */
    protected static $tagsModel = Tag::class;

    /**
     * The Slug generator method.
     *
     * @var string
     */
    protected static $slugGenerator = 'Illuminate\Support\Str::slug';

    /**
     * @return string
     */
    public static function getTagsDelimiter()
    {
        return static::$delimiter;
    }

    /**
     * @param $delimiter
     *
     * @return string
     */
    public static function setTagsDelimiter($delimiter)
    {
        static::$delimiter = $delimiter;

        return get_called_class();
    }

    /**
     * @return string
     */
    public static function getTagsModel()
    {
        return static::$tagsModel;
    }

    /**
     * @param $model
     */
    public static function setTagsModel($model)
    {
        static::$tagsModel = $model;
    }

    /**
     * @return string
     */
    public static function getSlugGenerator()
    {
        return static::$slugGenerator;
    }

    /**
     * @param $slugGenerator
     */
    public static function setSlugGenerator($slugGenerator)
    {
        static::$slugGenerator = $slugGenerator;
    }

    /**
     * @return mixed
     */
    public function tags()
    {
        return $this->morphToMany(static::$tagsModel, 'taggable', 'tagged', 'taggable_id', 'tag_id');
    }

    /**
     * @return mixed
     */
    public static function allTags()
    {
        $instance = new static;

        return $instance->createTagsModel()->whereNamespace(
            $instance->getEntityClassName()
        );
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $tags
     * @param string                                $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeWhereTag(Builder $query, $tags, $type = 'slug')
    {
        $tags = (new static)->prepareTags($tags);

        foreach ($tags as $tag) {
            $query->whereHas('tags', function ($query) use ($type, $tag) {
                $query->where($type, $tag);
            });
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $tags
     * @param string                                $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeWithTag(Builder $query, $tags, $type = 'slug')
    {
        $tags = (new static)->prepareTags($tags);

        return $query->whereHas('tags', function ($query) use ($type, $tags) {
            $query->whereIn($type, $tags);
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $tags
     * @param string                                $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeWithoutTag(Builder $query, $tags, $type = 'slug')
    {
        $tags = (new static)->prepareTags($tags);

        return $query->whereDoesntHave('tags', function ($query) use ($type, $tags) {
            $query->whereIn($type, $tags);
        });
    }

    /**
     * @param $tags
     *
     * @return bool
     */
    public function tag($tags)
    {
        foreach ($this->prepareTags($tags) as $tag) {
            $this->addTag($tag);
        }

        return true;
    }

    /**
     * @param null $tags
     *
     * @return bool
     */
    public function untag($tags = null)
    {
        $tags = $tags ?: $this->tags->pluck('name')->all();

        foreach ($this->prepareTags($tags) as $tag) {
            $this->removeTag($tag);
        }

        return true;
    }

    /**
     * @param        $tags
     * @param string $type
     *
     * @return bool
     */
    public function setTags($tags, $type = 'name')
    {
        // Prepare the tags
        $tags = $this->prepareTags($tags);

        // Get the current entity tags
        $entityTags = $this->tags->pluck($type)->all();

        // Prepare the tags to be added and removed
        $tagsToAdd = array_diff($tags, $entityTags);
        $tagsToDel = array_diff($entityTags, $tags);

        // Detach the tags
        if (! empty($tagsToDel)) {
            $this->untag($tagsToDel);
        }

        // Attach the tags
        if (! empty($tagsToAdd)) {
            $this->tag($tagsToAdd);
        }

        return true;
    }

    /**
     * @param $name
     */
    public function addTag($name)
    {
        $tag = $this->createTagsModel()->firstOrNew([
            'slug'      => $this->generateTagSlug($name),
            'namespace' => $this->getEntityClassName(),
        ]);

        if (! $tag->exists) {
            $tag->name = $name;

            $tag->save();
        }

        if (! $this->tags()->get()->contains($tag->id)) {
            $tag->update(['count' => $tag->count + 1]);

            $this->tags()->attach($tag);
        }

        $this->load('tags');
    }

    /**
     * @param $name
     */
    public function removeTag($name)
    {
        $slug = $this->generateTagSlug($name);

        $namespace = $this->getEntityClassName();

        $tag = $this
            ->createTagsModel()
            ->whereNamespace($namespace)
            ->where(function ($query) use ($name, $slug) {
                $query
                    ->orWhere('name', '=', $name)
                    ->orWhere('slug', '=', $slug);
            })
            ->first();

        if ($tag && $this->tags()->get()->contains($tag->id)) {
            $tag->update(['count' => $tag->count - 1]);

            $this->tags()->detach($tag);
        }

        $this->load('tags');
    }

    /**
     * @param $tags
     *
     * @return array
     */
    public function prepareTags($tags)
    {
        if (is_null($tags)) {
            return [];
        }

        if (is_string($tags)) {
            $delimiter = preg_quote($this->getTagsDelimiter(), '#');

            $tags = array_map('trim',
                preg_split("#[{$delimiter}]#", $tags)
            );
        }

        return array_unique(array_filter($tags));
    }

    /**
     * @return mixed
     */
    public static function createTagsModel()
    {
        return new static::$tagsModel;
    }

    /**
     * Generate the tag slug using the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function generateTagSlug($name)
    {
        return call_user_func(static::$slugGenerator, $name);
    }

    /**
     * Returns the entity class name.
     *
     * @return string
     */
    protected function getEntityClassName()
    {
        if (isset(static::$entityNamespace)) {
            return static::$entityNamespace;
        }

        return $this->tags()->getMorphClass();
    }
}
