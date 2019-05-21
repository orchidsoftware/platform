<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LockMeComposer
{
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @var \Illuminate\Auth\SessionGuard
     */
    private $guard;

    /**
     * LockMeComposer constructor.
     *
     * @param \Illuminate\Http\Request         $request
     * @param \Illuminate\Contracts\Auth\Guard $guard
     */
    public function __construct(Request $request, Guard $guard)
    {
        $this->request = $request;
        $this->guard = $guard;
    }


    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {
        $user = $this->request->cookie('lockUser');

        /** @var \Orchid\Platform\Models\User $model */
        $model = $this->guard->getProvider()->createModel()->find($user);

        $view->with('isLockUser', optional($model)->exists ?? false);

        \Illuminate\Support\Facades\View::composer('platform::auth.lockme', function($view) use ($model)
        {
            $view->with('lockUser',$model);
        });
    }
}
