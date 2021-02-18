<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Screen;

class AsyncController extends Controller
{
    /**
     * @param string $screen
     * @param string $method
     * @param string $layout
     *
     * @throws \Throwable
     *
     * @return mixed
     */
    public function load(string $screen, string $method, string $layout)
    {
        $screen = Crypt::decryptString($screen);

        /** @var Screen $screen */
        $screen = app($screen);

        return $screen->asyncBuild($method, $layout);
    }
}
