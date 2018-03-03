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

            TD::name('name')
                ->title(trans('dashboard::systems/users.name'))
                ->setRender(function ($user) {
                    return '<a href="'.route('dashboard.systems.users.edit',
                        $user->id).'">'.$user->name.'</a>';
                }),
            TD::name('email')->title(trans('dashboard::systems/users.email')),
            TD::name('updated_at')->title(trans('dashboard::common.Last edit')),

        ];
    }
}
