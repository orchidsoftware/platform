<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\InputField;

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
            InputField::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->horizontal()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            InputField::make('user.email')
                ->type('email')
                ->required()
                ->horizontal()
                ->hr(false)
                ->title(__('Email'))
                ->placeholder(__('Email')),
        ];
    }
}
