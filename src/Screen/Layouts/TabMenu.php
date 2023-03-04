<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Builder;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Throwable;

/**
 * Class TabMenu.
 */
abstract class TabMenu extends Layout
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.tabMenu';

    /**
     * @throws Throwable
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $form = new Builder($this->navigations(), $repository);

        return view($this->template, [
            'navigations'  => $form->generateForm(),
        ]);
    }

    /**
     * Get the menu elements to be displayed.
     *
     * @return Menu[]
     */
    abstract protected function navigations(): iterable;
}
