<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\Role;

use Orchid\Platform\Fields\TD;
use Orchid\Platform\Layouts\Table;

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
        return [];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            TD::set('id', 'ID')
                ->align('center')
                ->width('100px')
                ->sort()
                ->link('dashboard.systems.roles.edit', 'slug'),
            TD::set('name', trans('dashboard::systems/roles.name'))
                ->sort()
                ->link('dashboard.systems.roles.edit', 'slug', 'name'),
            TD::set('slug', trans('dashboard::systems/roles.slug'))
                ->sort(),
            TD::set('created_at', trans('dashboard::common.Created'))
                ->sort(),
        ];
    }
}
