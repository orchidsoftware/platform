<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Orchid\Platform\Core\Traits\Attachment;

class Menu extends Model
{
    use Attachment;

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
    public function children() : HasMany
    {
        return $this->hasMany(self::class, 'parent')->orderBy('sort', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent() : HasOne
    {
        return $this->hasOne(self::class);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getSons($id) : Collection
    {
        return $this->where('parent', $id)->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getAll($id) : Collection
    {
        return $this->where('type', $id)->oldest('id')->get();
    }
}
