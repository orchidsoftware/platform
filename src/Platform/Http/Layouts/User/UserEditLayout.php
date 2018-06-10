<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\User;

use Orchid\Screen\Fields\Field;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function fields(): array
    {
        return [
            Field::tag('input')
                ->type('text')
                ->name('user.name')
                ->max(255)
                ->required()
                ->title(trans('platform::systems/users.name'))
                ->placeholder(trans('platform::systems/users.name')),

            Field::tag('input')
                ->type('email')
                ->name('user.email')
                ->required()
                ->title(trans('platform::systems/users.email'))
                ->placeholder(trans('platform::systems/users.email')),

            Field::tag('password')
                ->name('user.password')
                ->title(trans('platform::systems/users.password'))
                ->placeholder('********'),
        ];
    }
}
