<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use App\Orchid\Filters\RoleFilter;

class UserListLayout extends Table
{
    /**
     * @var string
     */
    public $data = 'users';

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            RoleFilter::class,
        ];
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            TD::set('id', 'ID')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->sort()
                ->link('platform.systems.users.edit', 'id'),

            TD::set('name', __('Name'))
                ->sort()
                ->link('platform.systems.users.edit', 'id', 'name'),

            TD::set('email', __('Email'))
                ->loadModalAsync('oneAsyncModal', 'saveUser', 'id', 'email')
                ->sort(),

            TD::set('updated_at', __('Last edit'))
                ->sort(),
        ];
    }
}
