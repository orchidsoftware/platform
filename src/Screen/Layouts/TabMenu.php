<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Builder;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Throwable;

/**
 * Horizontal navigation for a short group of peer screens.
 */
abstract class TabMenu extends Layout
{
    protected $template = 'orchid::layouts.tabMenu';

    /**
     * @throws Throwable
     *
     * @return View|null
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        $navigations = $this->navigations();

        if (! $this->isSee() || empty($navigations)) {
            return null;
        }

        $form = new Builder($navigations, $repository);

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
