<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Component;

class SimpleShowValueWithArguments extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Application $application, public mixed $value, public string $from = 'Alexandr') {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    Hello {{ $value }} from {{ $from }}
    Is {{ $application->version() }} version.
</div>
blade;
    }
}
