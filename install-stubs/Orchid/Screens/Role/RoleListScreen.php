<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Platform\Models\Role;
use App\Orchid\Layouts\Role\RoleListLayout;

class RoleListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Roles';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Access rights';

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
            Link::name(__('Add'))
                ->icon('icon-plus')
                ->link(route('platform.systems.roles.create')),
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
}
