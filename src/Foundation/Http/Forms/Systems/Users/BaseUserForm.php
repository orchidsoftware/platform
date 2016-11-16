<?php

namespace Orchid\Foundation\Http\Forms\Systems\Users;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Facades\Dashboard;
use Orchid\Foundation\Services\Forms\Form;

class BaseUserForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Общие настройки';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = User::class;

    /**
     * Validation Rules Request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:255|unique:users,name,'.$this->request->get('name').',name',
            'email'        => 'required|email|max:255|unique:users,email,'.$this->request->get('email').',email',
            'password' => 'max:255|sometimes|required|min:8|confirmed',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param null $storage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($storage = null)
    {
        $user = $storage->get('model') ?: new $this->model;


        return view('dashboard::container.systems.users.info', [
            'user'  => $user,
        ]);
    }

    /**
     * Save Base Role.
     *
     * @param null $storage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist($storage = null)
    {
        $role = User::firstOrNew([
            'id' => $this->request->get('id'),
        ]);
        $role->fill($this->request->all());
        $role->save();
        Alert::success('Message');
    }
}
