<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\View\Component;

class SimpleShowValue extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public mixed $value) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    Hello {{ $value }}
</div>
blade;
    }
}
