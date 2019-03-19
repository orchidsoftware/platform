<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->horizontal()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->horizontal()
                ->title(__('Email'))
                ->placeholder(__('Email')),
        ];
    }
}
