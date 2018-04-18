<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Widgets;

use Orchid\Platform\Widget\Widget;
use Illuminate\Foundation\Inspiring;

class WelcomeQuote extends Widget
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|void
     */
    public function handler()
    {
        return view('qoute', [
            'inspiration' => Inspiring::quote(),
        ]);
    }
}
