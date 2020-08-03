<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;
use Orchid\Screen\Contracts\Actionable;
use Orchid\Screen\Repository;

/**
 * Class DropDown.
 *
 * @method DropDown name(string $name = null)
 * @method DropDown modal(string $modalName = null)
 * @method DropDown icon(string $icon = null)
 * @method DropDown class(string $classes = null)
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
        'class'  => 'btn btn-link',
        'source' => null,
        'icon'   => null,
        'list'   => [],
    ];

    /**
     * Create instance of the button.
     *
     * @param string $name
     *
     * @return DropDown
     */
    public static function make(string $name = ''): self
    {
        return (new static())
            ->name($name)
            ->addBeforeRender(function () use ($name) {
                $this->set('name', $name);
            });
    }

    /**
     * @param Actionable[] $list
     *
     * @return DropDown
     */
    public function list(array $list): self
    {
        return $this->set('list', $list);
    }

    /**
     * @param Repository|null $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Throwable
     */
    public function build(Repository $repository = null)
    {
        $this->set('source', $repository);

        return $this->render();
    }
}
