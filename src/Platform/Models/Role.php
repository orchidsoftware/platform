<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Access\RoleInterface;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements RoleInterface
{
    use RoleAccess, Filterable, AsSource;

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
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'slug',
        'permissions',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'slug',
        'updated_at',
        'created_at',
    ];

    /**
     * Set permission as boolean.
     *
     * @param array $permissions
     */
    public function setPermissionsAttribute(array $permissions = [])
    {
        foreach ($permissions as $key => $value) {
            $permissions[$key] = (bool) $value;
        }
        $this->attributes['permissions'] = json_encode($permissions ?? []);
    }
}
