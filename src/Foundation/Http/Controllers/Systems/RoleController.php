<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Systems\Roles\RoleFormGroup;
use Orchid\Foundation\Services\Forms\CrudFormTrait;

class RoleController extends Controller
{
    use CrudFormTrait;

    /**
     * @var
     */
    public $form = RoleFormGroup::class;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->form = new $this->form();
    }

    /**
     * @return string
     */
    public function index()
    {
        return $this->form->grid();
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->form->render();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->form->save();
        return redirect()->route('dashboard.systems.roles.edit', $request->get('slug'));
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $this->form->save($role);
        return redirect()->route('dashboard.systems.roles.edit', $request->get('slug'));
    }


    /**
     * @param Role $role
     */
    public function edit(Role $role)
    {
        $this->form->storage->put('model', $role);

        return $this->form->render();
    }


    /**
     * @param Role $role
     * @return mixed
     */
    public function destroy(Role $role)
    {
        $this->form->remove($role);
        return redirect()->route('dashboard.systems.roles');
    }

}
