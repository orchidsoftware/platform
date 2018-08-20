<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Illuminate\Support\Collection;
use Orchid\Press\Traits\Attachment;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use Attachment, LogsActivity;

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
     * @var string
     */
    protected static $logAttributes = ['*'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() : HasMany
    {
        return $this->hasMany(static::class, 'parent')->orderBy('sort');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent() : HasOne
    {
        return $this->hasOne(static::class);
    }

    /**
     * @param $id
     *
     * @return Collection
     */
    public function getSons($id) : Collection
    {
        return $this->where('parent', $id)->get();
    }

    /**
     * @param $id
     *
     * @return Collection
     */
    public function getAll($id) : Collection
    {
        return $this->where('type', $id)->oldest('id')->get();
    }
}
