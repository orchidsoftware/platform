<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Orchid\Screen\Fields\TD;
use Orchid\Access\UserAccess;
use Orchid\Screen\Fields\Field;
use Orchid\Access\UserInterface;
use Illuminate\Support\Collection;
use Orchid\Support\Facades\Dashboard;
use Orchid\Platform\Traits\FilterTrait;
use Illuminate\Notifications\Notifiable;
use Orchid\Platform\Traits\MultiLanguage;
use Spatie\Activitylog\Traits\LogsActivity;
use Orchid\Platform\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements UserInterface
{
    use Notifiable, UserAccess, MultiLanguage, FilterTrait, LogsActivity;

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
     * @var string
     */
    protected static $logAttributes = ['*'];

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
     * Display name.
     *
     * @return mixed
     */
    public function getNameTitle()
    {
        return $this->name;
    }

    /**
     * Display sub.
     *
     * @return string
     */
    public function getSubTitle()
    {
        return 'Administrator';
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Throwable
     */
    public static function getFieldsEdit(): Collection
    {
        return collect([
            'name' => Field::tag('input')
                ->type('text')
                ->name('user.name')
                ->max(255)
                ->required()
                ->title(trans('platform::systems/users.name'))
                ->placeholder(trans('platform::systems/users.name')),

            'email' => Field::tag('input')
                ->type('email')
                ->name('user.email')
                ->required()
                ->title(trans('platform::systems/users.email'))
                ->placeholder(trans('platform::systems/users.email')),

            'password' => Field::tag('password')
                ->name('user.password')
                ->title(trans('platform::systems/users.password'))
                ->placeholder('********'),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getFieldsTable(): Collection
    {
        return collect([
            'id'         => TD::set('id', 'ID')
                ->align('center')
                ->width('100px')
                ->sort()
                ->link('platform.systems.users.edit', 'id'),
            'name'       => TD::set('name', trans('platform::systems/users.name'))
                ->sort()
                ->link('platform.systems.users.edit', 'id', 'name'),
            'email'      => TD::set('email', trans('platform::systems/users.email'))
                ->loadModalAsync('oneAsyncModal', 'saveUser', 'id', 'email')
                ->sort(),
            'updated_at' => TD::set('updated_at', trans('platform::common.Last edit'))
                ->sort(),
        ]);
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
        if (static::where('email', $email)->exists()) {
            echo 'User exist', PHP_EOL;
            die();
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

    /**
     * @return string
     * @throws \Exception
     */
    public function getAvatar()
    {
        $rand = random_int(1, 16);

        return "/orchid/img/avatars/users-$rand.svg";
    }
}
