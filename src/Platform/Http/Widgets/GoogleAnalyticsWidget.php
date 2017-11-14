<?php

namespace Orchid\Platform\Http\Widgets;

use Orchid\Platform\Widget\Widget;

class GoogleAnalyticsWidget extends Widget
{

    /**
     * @return mixed
     */
    public function run()
    {
        return view('dashboard::widgets.analytics');
    }
}
