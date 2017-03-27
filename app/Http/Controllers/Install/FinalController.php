<?php

namespace Orchid\Http\Controllers\Install;

use Orchid\Http\Controllers\Install\Helpers\InstalledFileManager;
use Orchid\Http\Controllers\Controller;

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
