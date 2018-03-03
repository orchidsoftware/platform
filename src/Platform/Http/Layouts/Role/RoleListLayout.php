<?php

namespace Orchid\Platform\Http\Layouts\Role;

use Orchid\Platform\Layouts\Table;
use Orchid\Platform\Platform\Fields\TD;

class RoleListLayout extends Table
{
    /**
     * @var string
     */
    public $data = 'roles';

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters() : array
    {
        return [
        ];
    }
    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            TD::name('name')
                ->title(trans('dashboard::systems/roles.name'))
                ->setRender(function ($role) {
                    return '<a href="'.route('dashboard.systems.roles.edit',
                        $role->slug).'">'.$role->name.'</a>';
                }),
            TD::name('slug')->title(trans('dashboard::systems/roles.slug')),
            TD::name('created_at')->title(trans('dashboard::common.Created')),

        ];
    }
}
