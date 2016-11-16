<?php

namespace Orchid\Foundation\Services\Tags;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Foundation\Core\Models\Tag;

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
     * {@inheritdoc}
     */
    public static function setTagsDelimiter($delimiter)
    {
        static::$delimiter = $delimiter;

        return get_called_class();
    }

    /**
     * {@inheritdoc}
     */
    public static function getTagsModel()
    {
        return static::$tagsModel;
    }

    /**
     * {@inheritdoc}
     */
    public static function setTagsModel($model)
    {
        static::$tagsModel = $model;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSlugGenerator()
    {
        return static::$slugGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public static function setSlugGenerator($slugGenerator)
    {
        static::$slugGenerator = $slugGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public static function allTags()
    {
        $instance = new static();

        return $instance->createTagsModel()->whereNamespace(
            $instance->getEntityClassName()
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function createTagsModel()
    {
        return new static::$tagsModel();
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

    /**
     * {@inheritdoc}
     */
    public function tags()
    {
        return $this->morphToMany(static::$tagsModel, 'taggable', 'tagged', 'taggable_id', 'tag_id');
    }

    /**
     * {@inheritdoc}
     */
    public static function scopeWhereTag(Builder $query, $tags, $type = 'slug')
    {
        $tags = (new static())->prepareTags($tags);

        foreach ($tags as $tag) {
            $query->whereHas('tags', function (Builder $query) use ($type, $tag) {
                $query->where($type, $tag);
            });
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareTags($tags)
    {
        if (is_null($tags)) {
            return [];
        }

        if (is_string($tags)) {
            $delimiter = preg_quote($this->getTagsDelimiter(), '#');

            $tags = array_map('trim',
                preg_split("#[{$delimiter}]#", $tags, null, PREG_SPLIT_NO_EMPTY)
            );
        }

        return array_unique(array_filter($tags));
    }

    /**
     * {@inheritdoc}
     */
    public static function getTagsDelimiter()
    {
        return static::$delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public static function scopeWithTag(Builder $query, $tags, $type = 'slug')
    {
        $tags = (new static())->prepareTags($tags);

        return $query->whereHas('tags', function (Builder $query) use ($type, $tags) {
            $query->whereIn($type, $tags);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function setTags($tags, $type = 'name')
    {
        // Prepare the tags
        $tags = $this->prepareTags($tags);

        // Get the current entity tags
        $entityTags = $this->tags->lists($type)->all();

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
     * @param null $tags
     *
     * @return bool
     */
    public function untag($tags = null)
    {
        $tags = $tags ?: $this->tags->lists('name')->all();

        foreach ($this->prepareTags($tags) as $tag) {
            $this->removeTag($tag);
        }

        return true;
    }

    /**
     * @param $name
     */
    public function removeTag($name)
    {
        $namespace = $this->getEntityClassName();

        $tag = $this
            ->createTagsModel()
            ->whereNamespace($namespace)
            ->where(function ($query) use ($name) {
                $query
                    ->orWhere('name', $name)
                    ->orWhere('slug', $name);
            })
            ->first();

        if ($tag) {
            $tag->update(['count' => $tag->count - 1]);

            $this->tags()->detach($tag);
        }
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

        if (! $this->tags->contains($tag->id)) {
            $tag->update(['count' => $tag->count + 1]);

            $this->tags()->attach($tag);
        }
    }

    /**
     * Generate the tag slug using the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function generateTagSlug($name)
    {
        return call_user_func(static::$slugGenerator, $name);
    }
}
