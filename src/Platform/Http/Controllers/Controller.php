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
     * Ensure the current user has the required permission.
     *
     * This method uses middleware to enforce permission checks.
     * The check is done for each request to this controller or its routes.
     *
     * @param string $permission
     *
     * @return void
     */
    protected function checkPermission(string $permission): void
    {
        $this->middleware(static function ($request, $next) use ($permission) {
            if (Auth::user()->hasAccess($permission)) {
                return $next($request);
            }
            abort(403);
        });

        abort_if(Auth::user() !== null && ! Auth::user()->hasAccess($permission), 403);
    }
}
