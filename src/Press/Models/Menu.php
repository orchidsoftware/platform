<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\AttachTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use AttachTrait;

    /**
     * @var string
     */
    protected $table = 'menu';

    /**
     * @var array
     */
    protected $fillable = [
        'label',
        'title',
        'slug',
        'robot',
        'style',
        'target',
        'auth',
        'lang',
        'parent',
        'type',
        'sort',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'type'   => 'string',
        'parent' => 'integer',
        'sort'   => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent')->orderBy('sort');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne(static::class, 'id', 'parent');
    }
}
