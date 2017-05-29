<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Core\Traits\MultiLanguage;

class Term extends Model
{
    use MultiLanguage;

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
        'slug'    => 'string',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxonomy(): HasOne
    {
        return $this->hasOne(TermTaxonomy::class, 'term_id');
    }
}
