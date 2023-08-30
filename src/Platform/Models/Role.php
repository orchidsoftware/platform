<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Access\RoleAccess;
use Orchid\Access\RoleInterface;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Role extends Model implements RoleInterface
{
    use AsSource, Chartable, Filterable, HasFactory, RoleAccess;

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
        'id'          => Where::class,
        'name'        => Like::class,
        'slug'        => Like::class,
        'permissions' => Like::class,
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
