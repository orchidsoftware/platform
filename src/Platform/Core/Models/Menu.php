<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Core\Traits\Attachment;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function children() : HasMany
    {
        return $this->hasMany(self::class, 'parent');
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
