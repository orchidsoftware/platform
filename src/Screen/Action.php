<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Contracts\View\View;
use Orchid\Screen\Contracts\Actionable;
use Orchid\Support\Color;

class Action extends Field implements Actionable
{
    /**
     * Override the form view.
     */
    protected string|Closure|null $typeForm = 'platform::partials.fields.clear';

    /**
     * Attributes available for a particular tag.
     */
    protected array $inlineAttributes = [
        'type',
        'autofocus',
        'disabled',
        'tabindex',
    ];

    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     */
    protected array $translations = [
        'name',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public function name(?string $name = null): static
    {
        return $this->set('name', $name ?? '');
    }

    /**
     * Set the button's visual style based on the given `Color` enum.
     *
     * This method applies a CSS class to the action element that corresponds to
     * the desired button color, ensuring consistency with the platform's color palette.
     *
     * @param Color $visual The color style to apply to the button.
     *
     * @return static
     */
    public function type(Color $visual): static
    {
        $colors = array_map(static fn (Color $color) => 'btn-'.$color->name(), Color::cases());

        $class = str_replace($colors, '', (string) $this->get('class'));

        $this->set('class', $class.' btn-'.$visual->name());

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function build(?Repository $repository = null): ?View
    {
        return $this->render();
    }

    /**
     * Enable or disable Hotwire Turbo for this action's click event.
     *
     * By setting the `turbo` attribute, this method controls whether
     * Hotwire Turbo should be applied when the action is clicked.
     *
     * @param bool $status Set to `true` to disable Turbo, or `false` to enable it (default).
     *
     * @return static
     */
    public function rawClick(bool $status = false): static
    {
        $this->set('turbo', $status);

        return $this;
    }

    /**
     * Retrieve the unique ID assigned to this action element.
     *
     * If the ID is not explicitly set, this method returns `null`.
     *
     * @return string|null The ID of the action element, or null if not set.
     */
    protected function getId(): ?string
    {
        return $this->get('id');
    }

    /**
     * Adds the 'stretched-link' class to the element, making its parent block clickable.
     *
     * The `stretched` method appends the 'stretched-link' class to the element's 'class' attribute,
     * allowing the entire parent block of the element to become clickable.
     *
     * Notes: The parent block must have `position: relative`.
     *
     * @return self
     */
    public function stretched(): static
    {
        $this->attributes['class'] .= ' stretched-link';

        return $this;
    }
}
