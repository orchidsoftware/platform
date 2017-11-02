<?php

namespace Orchid\Platform\Http\Widgets;

use Orchid\Widget\Service\Widget;

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
