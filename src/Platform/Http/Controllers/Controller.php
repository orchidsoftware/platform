<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

/**
 * Class Controller.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param string $permission
     */
    protected function checkPermission(string $permission)
    {
        $this->middleware(static function ($request, $next) use ($permission) {
            if (Auth::guard(config('platform.guard'))->user()->hasAccess($permission)) {
                return $next($request);
            }
            abort(403);
        });

        abort_if(Auth::guard(config('platform.guard'))->user() !== null && ! Auth::guard(config('platform.guard'))->user()->hasAccess($permission), 403);
    }
}
