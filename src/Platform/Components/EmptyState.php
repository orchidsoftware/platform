<?php

declare(strict_types=1);

namespace Orchid\Platform\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * A concise placeholder for an empty collection or result.
 *
 * The icon, title, description, and default action slot are all optional.
 * Keep the copy brief and provide no more than one recovery action.
 */
class EmptyState extends Component
{
    /**
     * Initialize the icon, title and description for the empty state.
     *
     * @param string|null $icon
     * @param string|null $title
     * @param string|null $description
     */
    public function __construct(
        public ?string $icon = null,
        public ?string $title = null,
        public ?string $description = null,
    ) {}

    /**
     * Get the view that represents the component.
     */
    public function render(): View
    {
        return view('orchid::components.empty-state');
    }
}
