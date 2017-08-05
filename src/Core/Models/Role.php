<?php

namespace Orchid\Platform\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Platform\Access\RoleAccess;
use Orchid\Platform\Platform\Access\RoleInterface;

class Role extends Model implements RoleInterface
{
    use RoleAccess;

    /**
     * @var bool
     */
    public $timestamps = false;

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
