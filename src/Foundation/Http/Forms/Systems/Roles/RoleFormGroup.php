<?php namespace Orchid\Foundation\Http\Forms\Systems\Roles;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Events\Systems\RolesEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

class RoleFormGroup extends FormGroup
{

    /**
     * @var string
     */
    public $view = 'dashboard::container.systems.roles.roles';

    /**
     * @var
     */
    public $event = RolesEvent::class;


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function grid()
    {
        $role = new Role();
        $roles = $role->select('id', 'name', 'slug', 'created_at')->paginate();
        return view('dashboard::container.systems.roles.grid', [
            'roles' => $roles
        ]);
    }
}
