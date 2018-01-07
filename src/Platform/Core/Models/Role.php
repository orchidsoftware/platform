<?php

namespace Orchid\Platform\Core\Models;

use Orchid\Platform\Access\RoleAccess;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Access\RoleInterface;
use Orchid\Platform\Core\Traits\FilterTrait;

class Role extends Model implements RoleInterface
{
    use RoleAccess, FilterTrait;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'permissions',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'permissions' => 'array',
    ];
}
