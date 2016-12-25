<?php

namespace Orchid\Foundation\Core\Models;

use Orchid\Access\UserAccess;
use Orchid\Access\UserInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'about',
        'phone',
        'sex',
        'subscription',
        'nickname',
        'website',
        'avatar',
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
        'sex' => 'boolean',
        'subscription' => 'boolean',
        'about' => 'string',
        'permissions' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}
