<?php

namespace Orchid\Http\Controllers\Install;

use Orchid\Http\Controllers\Controller;
use Orchid\Http\Controllers\Install\Helpers\PermissionsChecker;

class PermissionsController extends Controller
{
    /**
     * @var PermissionsChecker
     */
    protected $permissions;

    /**
     * @param PermissionsChecker $checker
     */
    public function __construct(PermissionsChecker $checker)
    {
        $this->permissions = $checker;
    }

    /**
     * Display the permissions check page.
     *
     * @return \Illuminate\View\View
     */
    public function permissions()
    {
        $permissions = $this->permissions->check([
            'storage/app/'       => '755',
            'storage/framework/' => '755',
            'storage/logs/'      => '755',
            'bootstrap/cache/'   => '755',
        ]);

        return view('dashboard::container.install.permissions', compact('permissions'));
    }
}
