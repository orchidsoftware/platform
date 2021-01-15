<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\View\Component;

class EmptyComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return 'This message will not appear.';
    }

    /**
     * Determine if the component should be rendered.
     *
     * @return bool
     */
    public function shouldRender()
    {
        return false;
    }
}
