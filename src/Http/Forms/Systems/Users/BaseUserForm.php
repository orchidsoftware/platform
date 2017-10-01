<?php

namespace Orchid\Platform\Http\Forms\Systems\Users;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Forms\Form;

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
    public function rules() : array
    {
        return [
            'name'  => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->request->get('email') . ',email',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param User|null $user
     *
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function get(User $user = null) : View
    {
        return view('dashboard::container.systems.users.info', [
            'user' => $user ?: new $this->model(),
        ]);
    }

    /**
     * Save Base Role.
     *
     * @param Request|null $request
     * @param User|null    $user
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, User $user = null)
    {
        $attributes = $request->all();

        if (is_null($user)) {
            $user = new User();
        }

        if (array_key_exists('password', $attributes) && empty($attributes['password'])) {
            unset($attributes['password']);
        }

        $user->fill($attributes);
        if ($request->filled('password', null)) {
            $user->password = Hash::make($request->password);
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
