<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Orchid\Platform\Widget\WidgetContractInterface;

class WidgetController
{
    /**
     * @param WidgetContractInterface $widget
     * @param null                    $key
     *
     * @return mixed
     */
    public function index(WidgetContractInterface $widget, $key = null)
    {
        $widget->query = request('term');
        $widget->key = $key;

        if (! is_null($key)) {
            return response()->json($widget->handler());
        }

        return response()->json([
            'results' => $widget->handler(),
        ]);
    }
}
