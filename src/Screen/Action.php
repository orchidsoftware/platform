<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Contracts\Actionable;
use Orchid\Support\Color;

class Action extends Field implements Actionable
{
    /**
     * Override the form view.
     *
     * @var string
     */
    protected $typeForm = 'platform::partials.fields.clear';

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'type',
        'autofocus',
        'disabled',
        'tabindex',
    ];

    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     *
     * @var array
     */
    protected $translations = [
        'name',
    ];

    public function name(?string $name = null): self
    {
        return $this->set('name', $name ?? '');
    }

    /**
     * @return static
     */
    public function type(Color $visual): self
    {
        $colors = array_map(static fn (Color $color) => 'btn-'.$color->name(), Color::cases());

        $class = str_replace($colors, '', (string) $this->get('class'));

        $this->set('class', $class.' btn-'.$visual->name());

        return $this;
    }

    /**
     * @throws \Throwable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function build(?Repository $repository = null)
    {
        return $this->render();
    }

    /**
     * @return static
     */
    public function rawClick(bool $status = false): self
    {
        $this->set('turbo', $status);

        return $this;
    }

    /**
     * @return string
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
    public function stretched(): self
    {
        $this->attributes['class'] .= ' stretched-link';

        return $this;
    }
}
