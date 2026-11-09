<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use App\Orchid\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Orchid\Access\Permissions;
use Orchid\Access\UserAccess;
use Orchid\Filters\AllowedFilters;
use Orchid\Filters\AllowedSorts;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Metrics\Chartable;
use Orchid\Presenter\Presentable;
use Orchid\Presenter\UsePresenter;
use Orchid\Screen\AsSource;
use Orchid\Support\Facades\Orchid;

/**
 * This class serves as a base model for system users and is not intended
 * for direct use. It is recommended to extend this class when creating
 * custom user models, allowing flexibility in extending functionality
 * and modifying logic.
 *
 * The main idea is for this class to provide a standard implementation
 * that can be adapted to the specific needs of the application through
 * inheritance. This approach helps avoid modifying the base logic while
 * enabling the addition of unique features and behaviors in derived classes.
 *
 * Directly using this class may limit future extensibility and lead to
 * unintended changes in the behavior of the entire system.
 */
#[UsePresenter(UserPresenter::class)]
#[AllowedFilters([
    'id'         => Where::class,
    'name'       => Like::class,
    'email'      => Like::class,
    'updated_at' => WhereDateStartEnd::class,
    'created_at' => WhereDateStartEnd::class,
])]
#[AllowedSorts([
    'id',
    'name',
    'email',
    'updated_at',
    'created_at',
])]
class User extends Authenticatable
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, Presentable, UserAccess;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected function casts(): array
    {
        return [
            'permissions'          => Permissions::class,
            'email_verified_at'    => 'datetime',
        ];
    }

    /**
     * Throw an exception if email already exists, create admin user.
     *
     * @throws \Throwable
     */
    public static function createAdmin(string $name, string $email, string $password): void
    {
        throw_if(static::where('email', $email)->exists(), 'User exists');

        static::create([
            'name'        => $name,
            'email'       => $email,
            'password'    => Hash::make($password),
            'permissions' => Orchid::allowedPermissions(),
        ]);
    }
}
