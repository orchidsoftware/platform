<?php

namespace Orchid\Platform\Http\Controllers\Install;

use Orchid\Platform\Http\Controllers\Install\Helpers\InstalledFileManager;
use Orchid\Platform\Http\Controllers\Controller;

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

        return redirect()->to('/dashboard');
    }
}
