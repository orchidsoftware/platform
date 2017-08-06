<?php

namespace Orchid\Http\Forms\Systems\Users;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Core\Models\User;
use Orchid\Forms\Form;

class BaseUserForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Information';

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
    public function rules(): array
    {
        return [
            'name'  => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->request->get('email') . ',email',
            //'password' => 'max:255|sometimes|min:8|confirmed',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param User|null $user
     *
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function get(User $user = null): View
    {
        return view('dashboard::container.systems.users.info', [
            'user' => $user ?: new $this->model(),
        ]);
    }

    /**
     * Save Base Role.
     *
     * @param User|null $user
     */
    public function persist(User $user = null)
    {
        $attributes = $this->request->all();

        // We save permissions in AccessUserForm so we don't need them here
        $attributes['permissions'] = [];

        if (array_key_exists('password', $attributes) && empty($attributes['password'])) {
            unset($attributes['password']);
        }

        $user->fill($attributes);
        if (isset($attributes['password'])) {
            $user->password = Hash::make($attributes['password']);
        }

        $user->save();
    }

    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        $user->delete();
    }
}
