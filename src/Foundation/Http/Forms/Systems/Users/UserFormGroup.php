<?php

namespace Orchid\Foundation\Http\Forms\Systems\Users;

use Orchid\Forms\FormGroup;
use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Events\Systems\UserEvent;

class UserFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = UserEvent::class;

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
