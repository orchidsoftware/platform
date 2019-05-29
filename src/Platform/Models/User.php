<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Exception;
use Orchid\Screen\AsSource;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Access\UserInterface;
use Illuminate\Support\Facades\Hash;
use Orchid\Support\Facades\Dashboard;
use Illuminate\Notifications\Notifiable;
use Orchid\Platform\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Orchid\Platform\Notifications\DashboardNotification;

class User extends Authenticatable implements UserInterface
{
    use Notifiable, UserAccess, AsSource, Filterable;

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
        'permissions'       => 'array',
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
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
     * Display name.
     *
     * @return string
     */
    public function getNameTitle() : string
    {
        return $this->name;
    }

    /**
     * Display sub.
     *
     * @return string
     */
    public function getSubTitle() : string
    {
        return 'Administrator';
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @throws Exception
     */
    public static function createAdmin(string $name, string $email, string $password)
    {
        if (static::where('email', $email)->exists()) {
            throw new Exception('User exist');
        }

        $permissions = collect();

        Dashboard::getPermission()
            ->collapse()
            ->each(function ($item) use ($permissions) {
                $permissions->put($item['slug'], true);
            });

        $user = static::create([
            'name'        => $name,
            'email'       => $email,
            'password'    => Hash::make($password),
            'permissions' => $permissions,
        ]);

        $user->notify(new DashboardNotification([
            'title'   => "Welcome {$name}",
            'message' => 'You can find the latest news of the project on the website',
            'action'  => 'https://orchid.software/',
            'type'    => DashboardNotification::INFO,
        ]));
    }

    /**
     *@throws Exception
     *
     * @return string
     */
    public function getAvatar()
    {
        $hash = md5(strtolower(trim($this->email)));

        return "https://www.gravatar.com/avatar/$hash";
    }

    /**
     * @return mixed
     */
    public function getStatusPermission()
    {
        $permissions = $this->permissions ?? [];

        return Dashboard::getPermission()
            ->sort()
            ->transform(function ($group) use ($permissions) {
                $group = collect($group)->sortBy('description')->toArray();

                foreach ($group as $key => $value) {
                    $slug = $value['slug'];
                    $group[$key]['active'] = array_key_exists($slug, $permissions) && (bool) $permissions[$slug];
                }

                return $group;
            });
    }
}
