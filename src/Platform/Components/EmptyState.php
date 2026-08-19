<?php

declare(strict_types=1);

namespace Orchid\Platform\Components;

use Illuminate\Contracts\View\Factory;
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
    public function __construct(
        public ?string $icon = null,
        public ?string $title = null,
        public ?string $description = null,
    ) {}

    /**
     * Get the view that represents the component.
     */
    public function render(): Factory|View
    {
        return view('orchid::components.empty-state');
    }
}
