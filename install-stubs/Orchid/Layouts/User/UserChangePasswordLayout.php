<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class UserChangePasswordLayout extends Rows
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
            Field::tag('password')
                ->name('user.password')
                ->title(trans('platform::systems/users.password'))
                ->placeholder('********'),
        ];
    }
}
