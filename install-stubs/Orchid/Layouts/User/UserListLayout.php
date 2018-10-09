<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Orchid\Filters\RoleFilter;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

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
                ->align('center')
                ->width('100px')
                ->sort()
                ->link('platform.systems.users.edit', 'id'),

            TD::set('name', trans('platform::systems/users.name'))
                ->sort()
                ->link('platform.systems.users.edit', 'id', 'name'),

            TD::set('email', trans('platform::systems/users.email'))
                ->loadModalAsync('oneAsyncModal', 'saveUser', 'id', 'email')
                ->sort(),

            TD::set('updated_at', trans('platform::common.Last edit'))
                ->sort(),
        ];
    }
}
