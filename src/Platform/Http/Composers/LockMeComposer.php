<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Auth\EloquentUserProvider;

class LockMeComposer
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var SessionGuard
     */
    private $guard;

    /**
     * LockMeComposer constructor.
     *
     * @param Request $request
     * @param Guard   $guard
     */
    public function __construct(Request $request, Guard $guard)
    {
        $this->request = $request;
        $this->guard = $guard;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $user = $this->request->cookie('lockUser');

        /** @var EloquentUserProvider $provider */
        $provider = $this->guard->getProvider();

        $model = $provider->createModel()->find($user);

        $view->with('isLockUser', optional($model)->exists ?? false);

        \Illuminate\Support\Facades\View::composer('platform::auth.lockme', function ($view) use ($model) {
            $view->with('lockUser', $model);
        });
    }
}
