<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Alert;
use App\Orchid\Filters\RoleFilter;
use Illuminate\Support\Facades\Hash;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserListLayout;

class UserListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'User';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'All registered users';

    /**
     * Query data.
     *
     * @return array
     */
    public function query() : array
    {
        return  [
            'users'  => User::with('roles')
                ->filtersApply([RoleFilter::class])
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout() : array
    {
        return [
            UserListLayout::class,

            Layouts::modals([
                'oneAsyncModal' => [
                    UserEditLayout::class,
                ],
            ])->async('asyncGetUser'),
        ];
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function asyncGetUser(User $user) : array
    {
        return [
            'user' => $user,
        ];
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUser(User $user)
    {
        $attributes = $this->request->get('user');

        if (array_key_exists('password', $attributes) && empty($attributes['password'])) {
            unset($attributes['password']);
        } else {
            $user->password = Hash::make($attributes['password']);
            unset($attributes['password']);
        }

        $user->fill($attributes)->save();

        Alert::info(__('User was saved.'));

        return back();
    }
}
