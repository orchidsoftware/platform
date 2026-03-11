<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
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
    protected $view = 'orchid::actions.dropdown';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'  => 'btn btn-link icon-link gap-2',
        'source' => null,
        'icon'   => null,
        'list'   => [],
    ];

    /**
     * @param Actionable[] $list
     */
    public function list(array $list): self
    {
        return $this->set('list', $list);
    }

    /**
     * @throws \Throwable
     *
     * @return Factory|View|mixed
     */
    public function build(?Repository $repository = null)
    {
        $this->set('source', $repository);

        return $this->render();
    }
}
