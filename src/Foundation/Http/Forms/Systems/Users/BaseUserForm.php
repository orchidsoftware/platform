<?php

namespace Orchid\Foundation\Http\Forms\Systems\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Facades\Alert;

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
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users,email,'.$this->request->get('email').',email',
            //'password' => 'max:255|sometimes|min:8|confirmed',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param User|null $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get(User $user = null)
    {
        return view('dashboard::container.systems.users.info', [
            'user' => $user ?: new $this->model(),
        ]);
    }


    /**
     * Save Base Role.
     * @param Request|null $request
     * @param User|null $user
     * @return mixed|void
     */
    public function persist(Request $request = null, User $user = null)
    {
        $attributes = $request->all();

        if(key_exists('password',$attributes) && is_null($attributes['password'])){
            unset($attributes['password']);
        }

        $user->fill($attributes);
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
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
