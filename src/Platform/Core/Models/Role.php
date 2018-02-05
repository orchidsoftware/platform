<?php

declare(strict_types=1);

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

    /**
     * Set permission as boolean.
     *
     * @param  string  $value
     * @return void
     */
    public function setPermissionsAttribute($permissions)
    {
        foreach ($permissions as $key => $value) {
            $permissions[$key] = boolval($value);
        }
        $this->attributes['permissions'] = json_encode($permissions ?? []);
    }
}
