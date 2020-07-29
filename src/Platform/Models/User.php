<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use App\Orchid\Presenters\UserPresenter;
use Exception;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Orchid\Access\UserAccess;
use Orchid\Access\UserInterface;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Platform\Notifications\ResetPassword;
use Orchid\Screen\AsSource;
use Orchid\Support\Facades\Dashboard;

class User extends Authenticatable implements UserInterface
{
    use Notifiable, UserAccess, AsSource, Filterable, Chartable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login',
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
        'permissions',
        'uses_two_factor_auth',
        'two_factor_secret_code',
        'two_factor_recovery_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
        'last_login'           => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'last_login',
        'updated_at',
        'created_at',
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @throws \Throwable
     */
    public static function createAdmin(string $name, string $email, string $password)
    {
        throw_if(static::where('email', $email)->exists(), Exception::class, 'User exist');

        $permissions = Dashboard::getPermission()
            ->collapse()
            ->reduce(static function (Collection $permissions, array $item) {
                return $permissions->put($item['slug'], true);
            }, collect());

        static::create([
            'name'        => $name,
            'email'       => $email,
            'password'    => Hash::make($password),
            'permissions' => $permissions,
        ]);
    }

    /**
     * @return UserPresenter
     */
    public function presenter()
    {
        return new UserPresenter($this);
    }
}
