<?php

namespace Orchid\Platform\Http\Controllers;

use Orchid\Platform\Http\Requests\LockscreenRequest;

class DashboardController extends Controller
{

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {
        return view('dashboard::index', [
            'widgets' => config('platform.main_widgets', []),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function lock()
    {
        session()->put('lockscreen', true);
        if (request()->expectsJson()) {
            return response()->json([
                'locked'     => true,
                'suggestUrl' => '/lockscreen',
            ]);
        }

        return redirect('lockscreen');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unlock()
    {
        session()->put('lockscreen', false);

        return redirect('redirect_if_unlocked');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUnlockForm()
    {
        return view('dashboard::auth.lock');
    }
}
