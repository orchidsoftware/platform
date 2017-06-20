<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Access\RoleAccess;
use Orchid\Access\RoleInterface;

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
