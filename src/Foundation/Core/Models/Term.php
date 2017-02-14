<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Term extends Model
{
    /**
     * @var string
     */
    protected $table = 'terms';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'slug',
        'content',
        'term_group',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'content' => 'array',
        'slug' => 'string',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxonomy()
    {
        return $this->hasOne(TermTaxonomy::class, 'term_id');
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
}
