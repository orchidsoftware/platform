<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use Orchid\Screen\Fields\Field;
use Orchid\Screen\Layouts\Rows;

class RoleEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function fields(): array
    {
        return [
            Field::tag('input')
                ->type('text')
                ->name('role.name')
                ->max(255)
                ->required()
                ->title(trans('platform::systems/roles.name'))
                ->placeholder(trans('platform::systems/roles.name'))
                ->help(trans('platform::systems/roles.name_help')),

            Field::tag('input')
                ->type('text')
                ->name('role.slug')
                ->max(255)
                ->required()
                ->title(trans('platform::systems/roles.slug'))
                ->placeholder(trans('platform::systems/roles.slug'))
                ->help(trans('platform::systems/roles.slug_help')),
        ];
    }
}
