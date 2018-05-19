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
                ->link('platform.systems.roles.edit', 'slug'),
            TD::set('name', trans('platform::systems/roles.name'))
                ->sort()
                ->link('platform.systems.roles.edit', 'slug', 'name'),
            TD::set('slug', trans('platform::systems/roles.slug'))
                ->sort(),
            TD::set('created_at', trans('platform::common.Created'))
                ->sort(),
        ];
    }
}
