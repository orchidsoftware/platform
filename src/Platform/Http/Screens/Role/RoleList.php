<?php

namespace Orchid\Platform\Http\Screens\Role;

use Illuminate\Http\Request;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;

use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Http\Layouts\Role\RoleListLayout;

class RoleList extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'dashboard::systems/roles.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'dashboard::systems/roles.description';

    /**
     * Query data.
     *
     * @return array
     */
    public function query() : array
    {
        return [
            'roles' => Role::paginate(),
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
            Link::name(' '.trans('dashboard::common.commands.add'))->icon('icon-plus')->method('create'),
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
            RoleListLayout::class,
        ];
    }

    /**
     * @param Request $request
     *
     * @return null
     */
    public function create()
    {
        return redirect()->route('dashboard.systems.roles.create');
    }
}
