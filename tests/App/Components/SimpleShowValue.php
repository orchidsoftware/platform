<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\View\Component;
use Orchid\Platform\Models\User;

class SimpleShowValue extends Component
{
    /**
     * @var User
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

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
