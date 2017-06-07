<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Menu extends Model
{
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
    ];

    /**
     * @var array
     */
    protected $casts = [
        'type' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne(self::class);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getSons($id): Collection
    {
        return $this->where('parent', $id)->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getAll($id): Collection
    {
        return $this->where('type', $id)->orderBy('id', 'asc')->get();
    }
}
