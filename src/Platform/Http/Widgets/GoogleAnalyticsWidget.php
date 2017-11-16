<?php

namespace Orchid\Platform\Http\Widgets;

use Orchid\Platform\Widget\Widget;

class GoogleAnalyticsWidget extends Widget
{

    /**
     * @return mixed
     */
    public function handler()
    {
        return view('dashboard::widgets.analytics');
    }
}
