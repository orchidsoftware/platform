<?php

namespace Orchid\Foundation\Http\Forms\Systems\Users;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Facades\Dashboard;
use Orchid\Foundation\Http\Requests\Request;
use Orchid\Foundation\Services\Forms\Form;
use Illuminate\Support\Facades\Hash;

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
            'name'        => 'required|max:255',
            'email'        => 'required|email|max:255|unique:users,email,'.$this->request->get('email').',email',
            'password' => 'max:255|sometimes|min:8|confirmed',
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
     * @param null $request
     * @param null $user
     */
    public function persist($request = null, $user = null, $storage = null)
    {
        $user->fill($this->request->all());
        if($this->request->has('password')) {
            $user->password = Hash::make($this->request->password);
            $user->permissions = [];
        }
        $user->save();

        Alert::success('Message');
    }
}
