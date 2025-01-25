<?php

declare(strict_types=1);

namespace Orchid\Screen\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Popover extends Component
{

    public ?string $content;

    /**
     * Available options:
     * 'top', 'right', 'bottom',
     * 'left', 'auto'.
     */
    public string $placement;

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
     */
    public function render(): View|string
    {
        return view('platform::components.popover');
    }

    /**
     * Determine if the component should be rendered.
     *
     * @return bool
     */
    public function shouldRender(): bool
    {
        return !empty($this->content);
    }
}
