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

    /**
     * @param string|null $name
     *
     * @return self
     */
    public function name(string $name = null): self
    {
        return $this->set('name', $name ?? '');
    }

    /**
     * @param Color $visual
     *
     * @return static
     */
    public function type(Color $visual): self
    {
        $reflectionClass = new \ReflectionClass(Color::class);

        $colors = array_map(static function (string $color) {
            return 'btn-'.$color;
        }, $reflectionClass->getConstants());

        $class = str_replace($colors, '', (string) $this->get('class'));

        $this->set('class', $class.' btn-'.$visual);

        return $this;
    }

    /**
     * @param Repository|null $repository
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function build(Repository $repository = null)
    {
        return $this->render();
    }

    /**
     * @param bool $status
     *
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
}
