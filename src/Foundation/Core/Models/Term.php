<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

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
        'name',
        'slug',
        'term_group',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxonomy()
    {
        return $this->hasOne(TermTaxonomy::class, 'term_id');
    }
}
