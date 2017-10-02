<?php

namespace Orchid\Platform\Core\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Orchid\Platform\Access\UserAccess;
use Orchid\Platform\Access\UserInterface;

class User extends Authenticatable implements UserInterface
{
    use Notifiable, UserAccess;

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
        'last_login',
        'avatar',
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
        'permissions'  => 'array',
    ];
}
