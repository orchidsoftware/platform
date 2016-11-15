<?php namespace Orchid\Foundation\Core\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Orchid\Foundation\Services\Access\UserAccess;
use Orchid\Foundation\Services\Access\UserInterface;

class User extends Authenticatable implements UserInterface
{
    use Notifiable ,UserAccess;

    /**
     * @var
     */
    protected static $rolesModel = Role::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'permissions' => 'array',
    ];
}
