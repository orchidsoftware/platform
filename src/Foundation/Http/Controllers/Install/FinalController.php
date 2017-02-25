<?php

namespace Orchid\Foundation\Http\Controllers\Install;

use Orchid\Foundation\Helpers\InstalledFileManager;
use Orchid\Foundation\Http\Controllers\Controller;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     *
     * @return \Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager)
    {
        $fileManager->update();

        return view('dashboard::container.install.finished');
    }
}
