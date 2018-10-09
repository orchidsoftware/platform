<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use Orchid\Screen\Link;
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
    public $name = 'platform::systems/users.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/users.description';

    /**
     * Query data.
     *
     * @return array
     */
    public function query() : array
    {
        return  [
          'users'  => User::with('roles')
                ->FiltersApply([RoleFilter::class])
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
        return [
            Link::name(trans('platform::common.commands.add'))
                ->icon('icon-plus')
                ->method('create'),
        ];
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('platform.systems.users.create');
    }

    /**
     * @return array
     */
    public function asyncGetUser() : array
    {
        // переписать эту херню
        $id = $this->request->json()->all();
        $id = array_shift($id);
        // переписать эту херню

        $user = is_null($id) ? new User : User::findOrFail($id);

        return [
            'user' => $user,
        ];
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUser($id)
    {
        $user = User::findOrFail($id);

        $attributes = $this->request->get('user');

        if (array_key_exists('password', $attributes) && empty($attributes['password'])) {
            unset($attributes['password']);
        } else {
            $user->password = Hash::make($attributes['password']);
            unset($attributes['password']);
        }

        $user->fill($attributes)->save();

        Alert::info(trans('platform::systems/users.User was saved'));

        return back();
    }
}
