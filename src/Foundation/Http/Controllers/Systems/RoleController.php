<?php namespace Orchid\Foundation\Http\Controllers\Systems;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Services\Forms\CrudFormTrait;
use Orchid\Foundation\Http\Forms\Systems\Roles\RoleFormGroup;

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
        $this->form = new $this->form;
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
     * @return mixed
     */
    public function store()
    {
        $this->form->save();
    }


    /**
     * @param Role $role
     */
    public function edit(Role $role)
    {
        $this->form->storage->put('model', $role);
        return $this->form->render();
    }
}
