<?php

namespace Orchid\Core\Models;

use Cartalyst\Tags\TaggableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Orchid\Core\Builders\PostBuilder;
use Orchid\Core\Traits\MultiLanguage;
use Orchid\Exceptions\TypeException;
use Orchid\Facades\Dashboard;

class Post extends Model
{
    use TaggableTrait, Sluggable, MultiLanguage;


    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @deprecated
     * @deprecated 0.0.11
     * @deprecated No longer used by internal code and not recommended.
     * @deprecated 0.0.11 No longer used by internal code and not recommended.
     */
    protected $dataType = null;

    /**
     * Recording behavior
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    /**
     * @deprecated
     * @deprecated 0.0.11
     * @deprecated No longer used by internal code and not recommended.
     * @deprecated 0.0.11 No longer used by internal code and not recommended.
     *
     * @return mixed
     */
    public function whereType()
    {
        return $this->where('type', $this->dataType->slug);
    }

    /**
     * @param $slug
     *
     * @return $this
     * @throws TypeException
     */
    public function getBehavior($slug){

        $this->behavior = Dashboard::getTypes()->find($slug);

        if (is_null($this->behavior)) {
            throw new TypeException("{$slug} Type is not found");
        }

        return $this;
    }

    /**
     * Get Behavior Class
     *
     * @return null|object
     */
    public function getBehaviorObject(){
        if (!is_null($this->behavior)) {
            return $this->behavior;
        }
        return $this->getBehavior($this->getAttribute('type'))->behavior;

    }

    /**
     * @deprecated
     * @deprecated 0.0.11
     * @deprecated No longer used by internal code and not recommended.
     * @deprecated 0.0.11 No longer used by internal code and not recommended.
     *
     * @return null
     */
    public function getTypeObject()
    {
        return $this->getBehaviorObject();
    }

    /**
     * @param $getType
     *
     * @throws TypeException
     *
     * @return mixed
     */
    public function getType($getType)
    {
       $behavior = $this->getBehavior($getType);
       $this->dataType = $this->behavior;

        return $behavior;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptions() : Collection
    {
        return collect($this->options);
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
     * Get the author's posts.
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->belongsTo(Dashboard::model('user', User::class), 'user_id')->first();
    }

    /**
     * Get tags for post as string.
     *
     * @return mixed
     */
    public function getStringTags()
    {
        return $this->tags->implode('name', $this->getTagsDelimiter());
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
        $first = $this->attachment('image')->orderBy('sort', 'asc')->first();

        return $first ? $first->url($size) : null;
    }

    /**
     * Get attachment.
     *
     * @param null $type
     *
     * @return mixed
     */
    public function attachment($type = null) : HasMany
    {
        if (!is_null($type)) {
            return $this->hasMany(Dashboard::model('attachment', Attachment::class))->whereIn('extension',
                config('content.attachment.'.$type));
        }

        return $this->hasMany(Dashboard::model('attachment', Attachment::class));
    }

    /**
     * Taxonomy relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxonomies() : BelongsToMany
    {
        return $this->belongsToMany(TermTaxonomy::class, 'term_relationships', 'post_id', 'term_taxonomy_id');
    }

    /**
     * Comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Dashboard::model('comment', Comment::class), 'post_id');
    }

    /**
     *   Author relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() : BelongsTo
    {
        return $this->belongsTo(Dashboard::model('user', User::class), 'post_id');
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
     * Overriding newQuery() to the custom PostBuilder with some interesting methods.
     *
     * @param bool $excludeDeleted
     *
     * @return PostBuilder
     */
    public function newQuery($excludeDeleted = true) : PostBuilder
    {
        $builder = new PostBuilder($this->newBaseQueryBuilder());
        $builder->setModel($this)->with($this->with);
        // disabled the default orderBy because else Post::all()->orderBy(..)
        // is not working properly anymore.
        // $builder->orderBy('post_date', 'desc');
        if (isset($this->postType) && $this->postType) {
            $builder->type($this->postType);
        }
        if ($excludeDeleted && $this->softDelete) {
            $builder->whereNull($this->getQualifiedDeletedAtColumn());
        }

        return $builder;
    }
}
