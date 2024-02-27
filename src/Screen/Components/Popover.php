<?php

declare(strict_types=1);

namespace Orchid\Screen\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Popover extends Component
{
    /**
     * @var string|null
     */
    public $content;

    /**
     * Available options:
     * 'top', 'right', 'bottom',
     * 'left', 'auto'.
     *
     * @var string
     */
    public $placement;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $content = null, string $placement = 'auto')
    {
        $this->content = $content;
        $this->placement = $placement;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('platform::components.popover');
    }

    /**
     * Determine if the component should be rendered.
     *
     * @return bool
     */
    public function shouldRender()
    {
        return ! empty($this->content);
    }
}
