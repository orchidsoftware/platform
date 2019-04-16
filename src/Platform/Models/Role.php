<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Orchid\Access\RoleAccess;
use Orchid\Access\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Platform\Traits\MultiLanguageTrait;

class Role extends Model implements RoleInterface
{
    use RoleAccess, Filterable, MultiLanguageTrait;

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
