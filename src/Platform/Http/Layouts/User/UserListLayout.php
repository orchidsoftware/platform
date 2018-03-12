<?php

namespace Orchid\Platform\Http\Layouts\User;

use Orchid\Platform\Layouts\Table;
use Orchid\Platform\Platform\Fields\TD;
use Orchid\Platform\Http\Filters\RoleFilter;

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
    public function filters() : array
    {
        return [
            RoleFilter::class,
        ];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            TD::set('name',trans('dashboard::systems/users.name'))
                ->sort()
                ->setRender(function ($user) {
                    return '<a href="'.route('dashboard.systems.users.edit',
                        $user->id).'">'.$user->name.'</a>';
                }),
            TD::set('email',trans('dashboard::systems/users.email'))
                ->sort(),
            TD::set('updated_at',trans('dashboard::common.Last edit'))
                ->sort(),
        ];
    }
}
