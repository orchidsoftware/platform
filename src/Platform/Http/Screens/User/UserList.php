<?php

namespace Orchid\Platform\Http\Screens\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Notifications\DashboardNotification;

use Orchid\Platform\Screen\Screen;
use Orchid\Platform\Screen\Layouts;
use Orchid\Platform\Screen\Link;

use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Http\Layouts\User\UserListLayout;

use Orchid\Platform\Http\Filters\RoleFilter;

class UserList extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'dashboard::systems/users.title'; 

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'dashboard::systems/users.description';

    /**
     * Query data
     *
     * @return array
     */
    public function query() : array
    {
        return [
            'users' => User::filtersApply([
							RoleFilter::class,
						])->paginate()
        ];
    }

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [
            Link::name(' '.trans('dashboard::systems/users.create'))->icon('icon-plus')->method('create'),
        ];
    }

    /**
     * Views
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
     * @param Request $request
     *
     * @return null
     */
     public function create()
    {
        return redirect()->route('dashboard.systems.users.create');
    }
}