<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Screen;

class AsyncController extends Controller
{
    /**
     * @throws \Throwable
     *
     * @return mixed
     */
    public function load(Request $request)
    {
        $request->validate([
            '_call'     => 'required|string',
            '_screen'   => 'required|string',
            '_template' => 'required|string',
        ]);

        $screen = Crypt::decryptString(
            $request->input('_screen')
        );

        /** @var Screen $screen */
        $screen = app($screen);

        return $screen->asyncBuild(
            $request->input('_call'),
            $request->input('_template')
        );
    }

    /**
     * @param Request $request
     * @param string  $screen
     * @param string  $layout
     *
     * @throws BindingResolutionException
     * @throws \ReflectionException
     *
     * @return mixed
     */
    public function listener(Request $request, string $screen, string $layout)
    {
        $screen = Crypt::decryptString($screen);
        $layout = Crypt::decryptString($layout);

        /** @var Screen $screen */
        $screen = app($screen);

        /** @var Listener $layout */
        $layout = app($layout);

        return $screen->asyncPartialLayout($layout, $request);
    }
}
