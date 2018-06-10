<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\User;

use App\Layouts\TestRow;
use Orchid\Platform\Http\Layouts\User\UserEditLayout;
use Orchid\Platform\Http\Layouts\User\UserRoleLayout;
use Orchid\Platform\Models\User;
use Orchid\Screen\Layouts;
use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Platform\Http\Layouts\User\UserListLayout;

class UserList extends Screen
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
            'users' => User::filters()
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
                ]
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
     *
     */
    public function asyncGetUser() : array
    {
        // переписать эту херню
            $id = $this->request->json()->all();
            $id = array_shift($id);
        // переписать эту херню

        $user = is_null($id) ? new User() : User::findOrFail($id);

        return [
            'user' => $user,
        ];
    }

    public function saveUser()
    {
        dd('Сохранить пользователя');
    }
}
