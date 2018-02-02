<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Systems\Users;

use Illuminate\Http\Request;
use Orchid\Platform\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Core\Models\User;

class BaseUserForm extends Form
{
    /**
     * Base Model.
     *
     * @var
     */
    protected $model = User::class;

    /**
     * @var null
     */
    protected $behavior;

    /**
     * BaseUserForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('dashboard::systems/users.tabs.information');

        $user = config('platform.common.user');
        $this->behavior = (new $user);
        parent::__construct($request);
    }

    /**
     * Validation Rules Request.
     *
     * @return array
     */
    public function rules() : array
    {
        return $this->behavior->rules();
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
            'user'     => $user ?: new $this->model(),
            'language' => App::getLocale(),
            'locales'  => config('platform.locales'),
            'behavior' => $this->behavior,
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
