<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Orchid\Access\RoleAccess;
use Orchid\Access\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\FilterTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Orchid\Platform\Traits\MultiLanguageTrait;

class Role extends Model implements RoleInterface
{
    use RoleAccess, FilterTrait, MultiLanguageTrait, LogsActivity;

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
     * @var
     */
    protected $allowedFilters = [
        'id',
        'name',
        'slug',
        'permissions',
    ];

    /**
     * @var
     */
    protected $allowedSorts = [
        'id',
        'name',
        'slug',
    ];

    /**
     * @var string
     */
    protected static $logAttributes = ['*'];

    /**
     * Set permission as boolean.
     *
     * @param $permissions
     */
    public function setPermissionsAttribute($permissions)
    {
        foreach ($permissions as $key => $value) {
            $permissions[$key] = boolval($value);
        }
        $this->attributes['permissions'] = json_encode($permissions ?? []);
    }
}
