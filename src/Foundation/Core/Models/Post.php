<?php

namespace Orchid\Foundation\Core\Models;

use Cartalyst\Tags\TaggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Laravel\Scout\Searchable;
use Orchid\Foundation\Exceptions\TypeException;
use Orchid\Foundation\Facades\Dashboard;

class Post extends Model
{
    use Searchable, TaggableTrait;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var
     */
    protected $dataType = null;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'section_id',
        'content',
        'options',
        'slug',
        'publish_at',
        'created_at',
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [

        // Terms inside all taxonomies
        'terms',

        // Terms analysis
        'main_category',
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return mixed
     */
    public function whereType()
    {
        return $this->where('type', $this->dataType->slug);
    }

    /**
     * @return null
     */
    public function getTypeObject()
    {
        if (!is_null($this->dataType)) {
            return $this->dataType;
        } else {
            return $this->getType($this->getAttribute('type'))->dataType;
        }
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
        $types = Dashboard::types(true);
        foreach ($types as $type) {
            if ($type->slug == $getType) {
                $this->dataType = $type;
                break;
            }
        }

        if (is_null($this->dataType)) {
            throw new TypeException('Type is not found');
        }

        return $this;
    }

    /**
     * @param $field
     * @param null $lang
     *
     * @return mixed|null
     */
    public function getContent($field, $lang = null)
    {
        try {
            $lang = $lang ?: App::getLocale();
            if (!is_null($this->content) && !in_array($field, $this->getFillable())) {
                return $this->content[$lang][$field];
            } elseif (in_array($field, $this->getFillable())) {
                return $this->$field;
            }
        } catch (\ErrorException $exception) {
            $content = collect($this->content)->first();

            if (array_key_exists($field, $content)) {
                return $content[$field];
            }
        }
    }

    /**
     * @param $key
     * @param null $default
     *
     * @return null
     */
    public function getOption($key, $default = null)
    {
        $option = $this->options;

        if ($option == null) {
            $option = [];
        }

        if (array_key_exists($key, $option)) {
            return $option[$key];
        }

        return $default;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptions()
    {
        return collect($this->options);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function checkLanguage($key)
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
     * @return mixed
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
        return $this->tags->implode('name', $this->getTagsDelimiter());
    }

    /**
     * @return mixed
     */
    public function breadcrumb()
    {
        $section = $this->section()->first();

        return $section ? $section->breadcrumb() : [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
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
        $first = $this->attachment()->first();

        return $first ? $first->url($size) : null;
    }

    /**
     * Get attachment.
     *
     * @return mixed
     */
    public function attachment()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Taxonomy relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxonomies()
    {
        return $this->belongsToMany(TermTaxonomy::class, 'term_relationships', 'post_id', 'term_taxonomy_id');
    }

    /**
     * Comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     *   Author relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'post_id');
    }

    /**
     * Whether the post contains the term or not.
     *
     * @param string $taxonomy
     * @param string $term
     *
     * @return bool
     */
    public function hasTerm($taxonomy, $term)
    {
        return isset($this->terms[$taxonomy]) && isset($this->terms[$taxonomy][$term]);
    }

    /**
     * Gets the status attribute.
     *
     * @return string
     */
//    public function getStatusAttribute()
//    {
//        return $this->status;
//    }

    /**
     * Gets all the terms arranged taxonomy => terms[].
     *
     * @return array
     */
    public function getTermsAttribute()
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
     * Gets the first term of the first taxonomy found.
     *
     * @return string
     */
    public function getMainCategoryAttribute()
    {
        $mainCategory = 'Uncategorized';
        if (!empty($this->terms)) {
            $taxonomies = array_values($this->terms);
            if (!empty($taxonomies[0])) {
                $terms = array_values($taxonomies[0]);
                $mainCategory = $terms[0];
            }
        }

        return $mainCategory;
    }

    /**
     * Get only posts with a custom status.
     *
     * @param string $status
     *
     * @return mixed
     */
    public function status($status)
    {
        return $this->where('status', $status);
    }

    /**
     * Get only published posts.
     *
     * @return mixed
     */
    public function published()
    {
        return $this->status('publish');
    }

    /**
     * Get only posts from a custom post type.
     *
     * @param string $type
     *
     * @return mixed
     */
    public function type($type)
    {
        return $this->where('type', $type);
    }

    /**
     * Get only posts from an array of custom post types.
     *
     * @param array $type
     *
     * @return mixed
     */
    public function typeIn(array $type)
    {
        return $this->whereIn('type', $type);
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
}
