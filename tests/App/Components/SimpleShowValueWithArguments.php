<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Component;

class SimpleShowValueWithArguments extends Component
{
    /**
     * @var mixed
     */
    public $value;

    /**
     * @var Application
     */
    public $application;

    /**
     * @var string
     */
    public $from;

    /**
     * Create a new component instance.
     *
     * @param mixed $value
     */
    public function __construct(Application $application, $value, string $from = 'Alexandr')
    {
        $this->value = $value;
        $this->application = $application;
        $this->from = $from;
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
    Hello {{ $value }} from {{ $from }}
    Is {{ $application->version() }} version.
</div>
blade;
    }
}
