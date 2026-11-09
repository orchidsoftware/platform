<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ClosureComponent extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * Create a new component instance.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure
     */
    public function render()
    {
        return static fn (array $data) => 'Hello '.$data['name'];
    }
}
