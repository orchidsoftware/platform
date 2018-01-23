<?php

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Platform\Http\Forms\Systems\Users\UserFormGroup;

class UserController extends Controller
{
    /**
     * @var UserFormGroup
     */
    public $form;

    /**
     * UserController constructor.
     *
     * @param UserFormGroup $form
     */
    public function __construct(UserFormGroup $form)
    {
        $this->checkPermission('dashboard.systems.users');
        $this->form = $form;
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
    public function create()
    {
        return $this->form
            ->route('dashboard.systems.users.store')
            ->method('POST')
            ->render();
    }

    /**
     * @param Request   $request
     * @param User|null $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user = null)
    {
        $this->form->save($request, $user);

        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.systems.users');
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return $this->form
            ->route('dashboard.systems.users.update')
            ->slug($user->id)
            ->method('PUT')
            ->render($user);
    }

    /**
     * @param Request $request
     * @param User    $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $this->form->save($request, $user);

        Alert::success(trans('dashboard::common.alert.success'));

        return back();
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function destroy(User $user)
    {
        $this->form->remove($user);

        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.systems.users');
    }
}
