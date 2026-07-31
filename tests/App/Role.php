<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Access\Permissions;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;
use Orchid\Tests\App\Enums\RoleNames;

class Role extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, RoleAccess;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

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
        'permissions',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'permissions' => Permissions::class,
        'name'        => RoleNames::class,
    ];

    /**
     * @var array
     */
    protected $allowedFilters = [
        'id'          => Where::class,
        'name'        => Like::class,
        'permissions' => Like::class,
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'updated_at',
        'created_at',
    ];
}
