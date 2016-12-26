<?php

namespace Orchid\Foundation\Http\Forms\Systems\Users;

use Orchid\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Core\Models\User;

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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$this->request->get('email').',email',
            'password' => 'max:255|sometimes|min:8|confirmed',
        ];
    }

    /**
     * Display Settings App.
     * @param User|null $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get(User $user = null)
    {
        return view('dashboard::container.systems.users.info', [
            'user' => $user ?: new $this->model,
        ]);
    }

    /**
     * Save Base Role.
     *
     * @param null $request
     * @param null $user
     * @return null
     */
    public function persist($request = null, $user = null)
    {
        $user->fill($this->request->all());
        if ($this->request->has('password')) {
            $user->password = Hash::make($this->request->password);
            $user->permissions = [];
        }
        $user->save();

        Alert::success('Message');
    }

    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        $user->delete();
        Alert::success('Message');
    }
}
