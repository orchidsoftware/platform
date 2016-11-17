<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Systems\Users\UserFormGroup;
use Orchid\Foundation\Services\Forms\CrudFormTrait;

class UserController extends Controller
{
    use CrudFormTrait;

    /**
     * @var
     */
    public $form = UserFormGroup::class;

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
     * @param User|null $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->form->save();

        return redirect()->back();
    }

    /**
     * @param User $user
     */
    public function edit(User $user)
    {
        $this->form->storage->put('model', $user);

        return $this->form->render();
    }


    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user){
        $this->form->save($user);
        return redirect()->back();
    }
}
