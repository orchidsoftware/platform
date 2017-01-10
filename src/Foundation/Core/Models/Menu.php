<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

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
        'slug',
        'robot',
        'style',
        'target',
        'auth',
        'parent',
        'sort',
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
    public function getParent()
    {
        return $this->hasMany(self::class, 'parent');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getSons($id)
    {
        return $this->where('parent', $id)->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getAll($id)
    {
        return $this->where('type', $id)->orderBy('sort', 'asc')->get();
    }
}
