<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Orchid\Support\Facades\Dashboard;
use Orchid\Platform\Access\UserAccess;
use Orchid\Platform\Traits\FilterTrait;
use Illuminate\Notifications\Notifiable;
use Orchid\Platform\Access\UserInterface;
use Orchid\Platform\Traits\MultiLanguage;
use Orchid\Platform\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements UserInterface
{
    use Notifiable, UserAccess, MultiLanguage, FilterTrait;

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
        'permissions' => 'array',
    ];

    /**
     * @var
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * @var
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
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
     * Set permission as boolean.
     *
     * @param mixed $permissions
     */
    public function setPermissionsAttribute($permissions)
    {
        foreach ($permissions as $key => $value) {
            $permissions[$key] = boolval($value);
        }
        $this->attributes['permissions'] = json_encode($permissions ?? []);
    }

    /**
     * @param $name
     * @param $email
     * @param $password
     *
     * @return mixed
     */
    public static function createAdmin($name, $email, $password)
    {
        $permissions = collect();

        Dashboard::getPermission()
            ->collapse()
            ->each(function ($items) use ($permissions) {
                foreach ($items as $item) {
                    $permissions->put($item['slug'], true);
                }
            });

        $user = self::create([
                'name'        => $name,
                'email'       => $email,
                'password'    => bcrypt($password),
                'permissions' => $permissions,
        ]);

        $user->notify(new \Orchid\Platform\Notifications\DashboardNotification([
            'title'   => "Welcome {$name}",
            'message' => 'You can find the latest news of the project on the website',
            'action'  => 'https://orchid.software/',
            'type'    => 'info',
        ]));
    }
}
