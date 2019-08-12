<?php

declare(strict_types=1);

namespace Orchid\Screen\Commands;

use Orchid\Screen\Field;
use Orchid\Screen\Repository;
use Orchid\Screen\Contracts\ActionContract;

/**
 * Class DropDown.
 *
 * @method self name(string $name = null)
 * @method self modal(string $modalName = null)
 * @method self icon(string $icon = null)
 * @method self class(string $classes = null)
 * @method self group(array $group = null)
 */
class DropDown extends Field implements ActionContract
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
     * @var string
     */
    protected $view = 'platform::actions.dropdown';

    /**
     * Override the form view.
     *
     * @var string
     */
    protected $typeForm = 'platform::partials.fields.clear';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class' => 'btn btn-link dropdown-item',
        'icon'  => null,
        'list'  => [],
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'autofocus',
        'disabled',
        'tabindex',
        'href',
    ];

    /**
     * Create instance of the button.
     *
     * @param string $title
     *
     * @return self
     */
    public static function make(string $title): self
    {
        return (new static())->name($title);
    }

    /**
     * Align button to the right.
     *
     * @return $this
     */
    public function right(): self
    {
        $class = $this->get('class').' pull-right';

        $this->set('class', $class);

        return $this;
    }

    /**
     * @param ActionContract[] $list
     *
     * @return self
     */
    public function list(array $list) : self
    {
        return $this->set('list', $list);
    }

    /**
     * @param string $visual
     *
     * @return $this
     */
    public function type(string $visual): self
    {
        $class = str_replace([
            self::DEFAULT,
            self::SUCCESS,
            self::WARNING,
            self::DANGER,
            self::INFO,
            self::PRIMARY,
            self::SECONDARY,
            self::LIGHT,
            self::DARK,
            self::LINK,
        ], '', (string) $this->get('class'));

        $this->set('class', $class.' '.$visual);

        return $this;
    }

    /**
     * Set the button as block.
     *
     * @return $this
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
    public function build(Repository $repository)
    {
        $this->set('source', $repository);

        return $this->render();
    }
}
