<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;
use Orchid\Platform\Models\User;
use Illuminate\Support\Collection;
use Orchid\Support\Facades\Dashboard;
use Orchid\Press\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\AttachTrait;
use Orchid\Platform\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Platform\Traits\MultiLanguageTrait;
use Orchid\Press\Exceptions\EntityTypeException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Post.
 */
class Post extends Model
{
    use TaggableTrait,
        SoftDeletes,
        Sluggable,
        MultiLanguageTrait,
        Searchable,
        AttachTrait,
        FilterTrait;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * Recording entity.
     *
     * @var \Orchid\Press\Entities\Many|\Orchid\Press\Entities\Single|null
     */
    protected $entity;

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
     * @var array
     */
    protected $allowedFilters = [
        'id',
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
    protected $allowedSorts = [
        'id',
        'user_id',
        'type',
        'status',
        'slug',
        'publish_at',
        'created_at',
        'deleted_at',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug',
            ],
        ];
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->publish_at = Carbon::now();
        });

        self::saving(function ($model) {
            $model->createSlug($model->slug);
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     *
     * @throws \Throwable| EntityTypeException
     */
    public function toSearchableArray(): array
    {
        $entity = $this->getEntityObject();

        if (method_exists($entity, 'toSearchableArray')) {
            return $entity->toSearchableArray($this->toArray());
        }

        return [];
    }

    /**
     * Get Behavior Class.
     *
     * @param string|null $slug
     *
     * @return \Orchid\Press\Entities\Many|\Orchid\Press\Entities\Single|null
     *
     * @throws \Throwable|EntityTypeException
     */
    public function getEntityObject($slug = null)
    {
        if (! is_null($this->entity)) {
            return $this->entity;
        }

        return $this->getEntity($slug ?? $this->getAttribute('type'))->entity;
    }

    /**
     * @param string $slug
     *
     * @return $this
     *
     * @throws \Throwable|EntityTypeException
     */
    public function getEntity(string $slug): self
    {
        $this->entity = Dashboard::getEntities()->where('slug', $slug)->first();

        throw_if(is_null($this->entity), EntityTypeException::class, "{$slug} Type is not found");

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptions(): Collection
    {
        return collect($this->options);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return null
     */
    public function getOption($key, $default = null)
    {
        $option = $this->getAttribute('options');

        if (! is_array($option)) {
            $option = [];
        }

        if (array_key_exists($key, $option)) {
            return $option[$key];
        }

        return $default;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function checkLanguage(string $key): bool
    {
        $locale = $this->getOption('locale', []);

        if (array_key_exists($key, Arr::wrap($locale))) {
            return filter_var($locale[$key], FILTER_VALIDATE_BOOLEAN);
        }

        return false;
    }

    /**
     * Get the author's posts.
     *
     * @return Model|null|object|static
     */
    public function getUser()
    {
        return $this->belongsTo(Dashboard::model(User::class), 'user_id')->first();
    }

    /**
     * Comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Dashboard::model(Comment::class), 'post_id');
    }

    /**
     *   Author relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Dashboard::model(User::class), 'user_id');
    }

    /**
     * Whether the post contains the term or not.
     *
     * @param string $taxonomy
     * @param string $term
     *
     * @return bool
     */
    public function hasTerm($taxonomy, $term): bool
    {
        return isset($this->getTermsAttribute()[$taxonomy][$term]);
    }

    /**
     * Gets all the terms arranged taxonomy => terms[].
     *
     * @return array
     */
    public function getTermsAttribute(): array
    {
        $taxonomies = $this->taxonomies;
        foreach ($taxonomies as $taxonomy) {
            $taxonomyName =
                $taxonomy['taxonomy'] === 'post_tag' ? 'tag' : $taxonomy['taxonomy'];
            $terms[$taxonomyName][$taxonomy->term['slug']] = $taxonomy->term->content;
        }

        return $terms ?? [];
    }

    /**
     * Taxonomy relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxonomies(): BelongsToMany
    {
        return $this->belongsToMany(Dashboard::model(Taxonomy::class), 'term_relationships', 'post_id', 'term_taxonomy_id');
    }

    /**
     * @param Builder $query
     * @param string $taxonomy
     * @param mixed $term
     *
     * @return Builder
     */
    public function scopeTaxonomy(Builder $query, $taxonomy, $term): Builder
    {
        return $query->whereHas('taxonomies', function ($query) use ($taxonomy, $term) {
            $query->where('taxonomy', $taxonomy)->whereHas('term', function ($query) use ($term) {
                $query->where('slug', $term);
            });
        });
    }

    /**
     * Get only published posts.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->status('publish');
    }

    /**
     * Get only posts with a custom status.
     *
     * @param Builder $query
     * @param string $postStatus
     *
     * @return Builder
     */
    public function scopeStatus(Builder $query, string $postStatus): Builder
    {
        return $query->where('status', $postStatus);
    }

    /**
     * Get only posts from a custom post type.
     *
     * @param Builder $query
     * @param string $type
     *
     * @return Builder
     */
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Get only posts from an array of custom post types.
     *
     * @param Builder $query
     * @param array $type
     *
     * @return Builder
     */
    public function scopeTypeIn(Builder $query, array $type): Builder
    {
        return $query->whereIn('type', $type);
    }

    /**
     * @param Builder $query
     * @param null $entity
     *
     * @return Builder
     * @throws \Throwable
     */
    public function scopeFiltersApply(Builder $query, $entity = null): Builder
    {
        if (! is_null($entity)) {
            try {
                $this->getEntity($entity);
            } catch (EntityTypeException $e) {
            }
        }

        return $this->filter($query);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    private function filter(Builder $query): Builder
    {
        $filters = $this->entity->getFilters();

        foreach ($filters as $filter) {
            $query = $filter->filter($query);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param null $entity
     *
     * @return Builder
     * @throws \Throwable | EntityTypeException
     */
    public function scopeFiltersApplyDashboard(Builder $query, $entity = null): Builder
    {
        if (! is_null($entity)) {
            $this->getEntity($entity);
        }

        return $this->filter($query);
    }

    /**
     * @param string|null $slug
     *
     * @throws \Orchid\Press\Exceptions\EntityTypeException
     * @throws \Throwable
     */
    public function createSlug($slug = null)
    {
        if (! is_null($slug) && $this->getOriginal('slug') === $slug) {
            $this->setAttribute('slug', $slug);

            return;
        }

        if (is_null($slug)) {
            $entityObject = $this->getEntityObject();
            if (property_exists($entityObject, 'slugFields')) {
                $content = $this->getAttribute('content');
                $slug = head($content)[$entityObject->slugFields] ?? '';
            }
        }

        $this->setAttribute('slug', SlugService::createSlug(
            Dashboard::modelClass(self::class),
            'slug',
            $slug, [
            'includeTrashed' => true,
        ]));
    }

    /**
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'slug';
    }
}
