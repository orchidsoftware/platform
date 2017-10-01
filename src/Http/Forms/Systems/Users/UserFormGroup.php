<?php

namespace Orchid\Platform\Http\Forms\Systems\Users;

use Illuminate\Contracts\View\View;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Events\Systems\UserEvent;
use Orchid\Platform\Forms\FormGroup;

class UserFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = UserEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes() : array
    {
        return [
            'name'        => trans('dashboard::systems/users.title'),
            'description' => trans('dashboard::systems/users.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main() : View
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
