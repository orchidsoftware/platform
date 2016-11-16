<?php

namespace Orchid\Foundation\Http\Forms\Systems\Users;

use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Events\Systems\UserEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

class UserFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = UserEvent::class;


    /**
     * Route available list.
     * @var array
     */
    public $route = [
        'index' => 'dashboard.systems.users',
        'create' => 'dashboard.systems.users.create',
        'edit' => 'dashboard.systems.users.edit',
        'update' => 'dashboard.systems.users.update',
        'store' => 'dashboard.systems.users.store',
        'destroy' => 'dashboard.systems.users.destroy',
    ];

    /**
     * Description Attributes for group.
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Пользователи',
            'description' => 'Описание раздела пользователи',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        $user = new User();
        $users = $user->select('id', 'name', 'email', 'created_at', 'updated_at')->paginate();

        return view(
            'dashboard::container.systems.users.grid',
            [
                'users' => $users,
            ]
        );
    }
}
