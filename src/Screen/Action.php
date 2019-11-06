<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Contracts\ActionContract;

class Action extends Field implements ActionContract
{
    /**
     * Visual style.
     */
    public const DEFAULT = 'btn-default';
    public const SUCCESS = 'btn-success';
    public const WARNING = 'btn-warning';
    public const DANGER = 'btn-danger';
    public const INFO = 'btn-info';
    public const PRIMARY = 'btn-primary';
    public const SECONDARY = 'btn-secondary';
    public const LIGHT = 'btn-light';
    public const DARK = 'btn-dark';
    public const LINK = 'btn-link';

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
     * Align button to the right.
     *
     * @return static
     */
    public function right(): self
    {
        $class = $this->get('class').' pull-right';

        $this->set('class', $class);

        return $this;
    }

    /**
     * @param string $visual
     *
     * @return static
     */
    public function type(string $visual): self
    {
        $class = str_replace([
            static::DEFAULT,
            static::SUCCESS,
            static::WARNING,
            static::DANGER,
            static::INFO,
            static::PRIMARY,
            static::SECONDARY,
            static::LIGHT,
            static::DARK,
            static::LINK,
        ], '', (string) $this->get('class'));

        $this->set('class', $class.' '.$visual);

        return $this;
    }

    /**
     * Set the button as block.
     *
     * @return static
     */
    public function block(): self
    {
        $class = $this->get('class').' pull-block';

        $this->set('class', $class);

        return $this;
    }

    /**
     * @param Repository $repository
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
        $this->set('turbolinks', $status);

        return $this;
    }
}
