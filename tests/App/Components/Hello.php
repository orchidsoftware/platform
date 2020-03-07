<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Component;

class Hello extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var Application
     */
    public $application;

    /**
     * Create a new component instance.
     *
     * @param Application $application
     * @param string      $name
     */
    public function __construct(Application $application, string $name)
    {
        $this->application = $application;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    Hello {{ $name }}! Is {{ $application->version() }} version.
</div>
blade;
    }
}
