<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;
use Orchid\Screen\Contracts\ActionContract;
use Orchid\Screen\Repository;

/**
 * Class DropDown.
 *
 * @method self name(string $name = null)
 * @method self modal(string $modalName = null)
 * @method self icon(string $icon = null)
 * @method self class(string $classes = null)
 */
class DropDown extends Action
{
    /**
     * @var string
     */
    protected $view = 'platform::actions.dropdown';

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
     * Create instance of the button.
     *
     * @param string $name
     *
     * @return self
     */
    public static function make(string $name): self
    {
        return (new static())
            ->name($name)
            ->addBeforeRender(function () use ($name) {
                $this->set('name', $name);
            });
    }

    /**
     * @param ActionContract[] $list
     *
     * @return $this
     */
    public function list(array $list) : self
    {
        return $this->set('list', $list);
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
