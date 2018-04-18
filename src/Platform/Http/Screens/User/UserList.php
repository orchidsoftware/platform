<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\User;

use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Http\Layouts\User\UserListLayout;

class UserList extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'dashboard::systems/users.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'dashboard::systems/users.description';

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
            Link::name(trans('dashboard::common.commands.add'))
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
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('dashboard.systems.users.create');
    }
}
