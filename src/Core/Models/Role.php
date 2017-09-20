<?php

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Access\RoleAccess;
use Orchid\Platform\Access\RoleInterface;
use Orchid\CMS\Core\Traits\Attachment;

class Role extends Model implements RoleInterface
{
    use RoleAccess, Attachment;

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
