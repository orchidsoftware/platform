<?php

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Core\Traits\MultiLanguage;
use Orchid\Platform\Core\Traits\RepositoryFields;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Term extends Model
{
    use MultiLanguage, RepositoryFields;

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

    public function getRepositoryFields(): array
    {
        return [
            'content'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxonomy() : HasOne
    {
        return $this->hasOne(Taxonomy::class, 'term_id');
    }
}
