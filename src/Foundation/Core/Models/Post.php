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
        'types_id',
        'users_id',
        'type',
        'section_id',
        'content',
        'options',
        'slug',
        'publish',
        'created_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'page'    => 'boolean',
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
        'created_at',
        'updated_at',
        'deleted_at',
        'publish_at',
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
     * @return mixed
     */
    public function attachment()
    {
        return $this->hasMany(File::class);
    }
}
