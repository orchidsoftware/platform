<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Contracts\View\View;
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

    protected string $view = 'platform::actions.dropdown';

    /**
     * Default attributes value.
     */
    protected array $attributes = [
        'class'  => 'btn btn-link icon-link',
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
     */
    public function build(?Repository $repository = null): ?View
    {
        $this->set('source', $repository);

        return $this->render();
    }
}
