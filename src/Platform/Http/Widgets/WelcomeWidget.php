<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Widgets;

use Orchid\Widget\Widget;
use Illuminate\Foundation\Inspiring;

class WelcomeWidget extends Widget
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|void
     */
    public function handler()
    {
        return view('platform::widgets.welcome');
    }
}
