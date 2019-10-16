<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;


use Illuminate\Support\Collection;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Access\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Orchid\Support\Facades\Dashboard;

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
}
