<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Models;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Cartalyst\Tags\TaggableTrait;
use Illuminate\Support\Collection;
use Orchid\Platform\Facades\Dashboard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
use Orchid\Platform\Core\Traits\Attachment;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Platform\Exceptions\TypeException;
use Orchid\Platform\Core\Traits\JsonRelations;
use Orchid\Platform\Core\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use SoftDeletes, TaggableTrait, Sluggable, MultiLanguage, Searchable, Attachment, JsonRelations;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * Recording behavior.
     *
     * @var null
     */
    protected $behavior = null;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'content',
        'options',
        'slug',
        'publish_at',
        'created_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'type'    => 'string',
        'slug'    => 'string',
        'content' => 'array',
        'options' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'publish_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug',
            ],
        ];
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     * @throws TypeException
     */
    public function toSearchableArray()
    {
        $behavior = $this->getBehaviorObject();

        if (method_exists($behavior, 'toSearchableArray')) {
            return $behavior->toSearchableArray($this->toArray());
        }

        return [];
    }

    /**
     * Get Behavior Class.
     *
     * @param null $slug
     *
     * @return null
     * @throws TypeException
     */
    public function getBehaviorObject($slug = null)
    {
        if (! is_null($this->behavior)) {
            return $this->behavior;
        }

        return $this->getBehavior($slug ?: $this->getAttribute('type'))->behavior;
    }

    /**
     * @param $slug
     *
     * @return $this
     * @throws TypeException
     */
    public function getBehavior($slug)
    {
        $this->behavior = Dashboard::getStorage('posts')->find($slug);

        if (is_null($this->behavior)) {
            throw new TypeException("{$slug} Type is not found");
        }

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptions() : Collection
    {
        return collect($this->options);
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return null
     */
    public function getOption($key, $default = null)
    {
        $option = $this->options;

        if (is_null($option)) {
            $option = [];
        }

        if (array_key_exists($key, $option)) {
            return $option[$key];
        }

        return $default;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function checkLanguage($key) : bool
    {
        $locale = $this->getOption('locale', []);

        if (array_key_exists($key, $locale)) {
            return filter_var($locale[$key], FILTER_VALIDATE_BOOLEAN);
        }

        return false;
    }

    /**
     * Get the author's posts.
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id')->first();
    }

    /**
     * Get tags for post as string.
     *
     * @return mixed
     */
    public function getStringTags()
    {
        return $this->tags->implode('name', static::getTagsDelimiter());
    }

    /**
     * Main image (First image).
     *
     * @param null $size
     *
     * @return mixed
     */
    public function hero($size = null)
    {
        $first = $this->attachment('image')->oldest('sort')->first();

        return $first ? $first->url($size) : null;
    }

    /**
     * Comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     *   Author relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Whether the post contains the term or not.
     *
     * @param string $taxonomy
     * @param string $term
     *
     * @return bool
     */
    public function hasTerm($taxonomy, $term) : bool
    {
        return isset($this->terms[$taxonomy]) && isset($this->terms[$taxonomy][$term]);
    }

    /**
     * Gets all the terms arranged taxonomy => terms[].
     *
     * @return array
     */
    public function getTermsAttribute() : array
    {
        $taxonomies = $this->taxonomies;
        $terms = [];
        foreach ($taxonomies as $taxonomy) {
            $taxonomyName = $taxonomy['taxonomy'] == 'post_tag' ? 'tag' : $taxonomy['taxonomy'];
            $terms[$taxonomyName][$taxonomy->term['slug']] = $taxonomy->term['name'];
        }

        return $terms;
    }

    /**
     * Taxonomy relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function scopeTaxonomies() : BelongsToMany
    {
        return $this->belongsToMany(Taxonomy::class, 'term_relationships', 'post_id', 'term_taxonomy_id');
    }

    /**
     * @param string $taxonomy
     * @param mixed  $term
     *
     * @return mixed
     */
    public function taxonomy($taxonomy, $term)
    {
        return $this->whereHas('taxonomies', function ($query) use ($taxonomy, $term) {
            $query->where('taxonomy', $taxonomy)->whereHas('term', function ($query) use ($term) {
                $query->where('slug', $term);
            });
        });
    }

    /**
     * @param $title
     *
     * @return string
     */
    public function makeSlug($title) : string
    {
        $slug = Str::slug($title);
        $count = self::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Get only published posts.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePublished(Builder $query) : Builder
    {
        return $query->status('publish');
    }

    /**
     * Get only posts with a custom status.
     *
     * @param Builder $query
     * @param string  $postStatus
     *
     * @return Builder
     */
    public function scopeStatus(Builder $query, string $postStatus) : Builder
    {
        return $query->where('status', $postStatus);
    }

    /**
     * Get only posts from a custom post type.
     *
     * @param Builder $query
     * @param string  $type
     *
     * @return Builder
     */
    public function scopeType(Builder $query, string $type) : Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Get only posts from an array of custom post types.
     *
     * @param Builder $query
     * @param array   $type
     *
     * @return Builder
     */
    public function scopeTypeIn(Builder $query, array $type) : Builder
    {
        return $query->whereIn('type', $type);
    }

    /**
     * @param Builder $query
     * @param null    $behavior
     *
     * @return Builder
     */
    public function scopeFiltersApply(Builder $query, $behavior = null) : Builder
    {
        if (! is_null($behavior)) {
            try {
                $this->getBehavior($behavior);
            } catch (TypeException $e) {
            }
        }

        return $this->filter($query);
    }

    /**
     * @param Builder $query
     * @param bool    $dashboard
     *
     * @return Builder
     */
    private function filter(Builder $query, $dashboard = false) : Builder
    {
        $filters = $this->behavior->getFilters($dashboard);

        foreach ($filters as $filter) {
            $query = $filter->filter($query);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param null    $behavior
     *
     * @return Builder
     * @throws TypeException
     */
    public function scopeFiltersApplyDashboard(Builder $query, $behavior = null) : Builder
    {
        if (! is_null($behavior)) {
            $this->getBehavior($behavior);
        }

        return $this->filter($query, true);
    }
}
