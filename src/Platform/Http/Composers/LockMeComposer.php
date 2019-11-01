<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

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
     * @var Factory
     */
    private $factoryView;

    /**
     * LockMeComposer constructor.
     *
     * @param Request $request
     * @param Guard   $guard
     */
    public function __construct(Request $request, Guard $guard, Factory $factoryView)
    {
        $this->request = $request;
        $this->guard = $guard;
        $this->factoryView = $factoryView;
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

        $this->factoryView->composer('platform::auth.lockme', static function (View $view) use ($model) {
            $view->with('lockUser', $model);
        });
    }
}
