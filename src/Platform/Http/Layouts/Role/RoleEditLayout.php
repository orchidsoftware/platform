<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\Role;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class RoleEditLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {
        return [
            Field::tag('input')
                ->type('text')
                ->name('role.name')
                ->max(255)
                ->required()
                ->title(trans('dashboard::systems/roles.name'))
                ->placeholder(trans('dashboard::systems/roles.name'))
                ->help(trans('dashboard::systems/roles.name_help')),

            Field::tag('input')
                ->type('text')
                ->name('role.slug')
                ->max(255)
                ->required()
                ->title(trans('dashboard::systems/roles.slug'))
                ->placeholder(trans('dashboard::systems/roles.slug'))
                ->help(trans('dashboard::systems/roles.slug_help')),
        ];
    }
}
