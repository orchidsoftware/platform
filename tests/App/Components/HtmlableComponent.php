<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\Component;

class HtmlableComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return new class() implements Htmlable
        {
            public function toHtml()
            {
                return 'Hello word';
            }
        };
    }
}
