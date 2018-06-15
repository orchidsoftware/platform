<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\Role;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Http\Layouts\Role\RoleListLayout;

class RoleList extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::systems/roles.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/roles.description';

    /**
     * Query data.
     *
     * @return array
     */
    public function query() : array
    {
        return [
            'roles' => Role::filters()->defaultSort('id', 'desc')->paginate(),
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
            RoleListLayout::class,
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('platform.systems.roles.create');
    }
}
