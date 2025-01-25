<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Builder;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Illuminate\Contracts\View\View;

/**
 * Class TabMenu.
 */
abstract class TabMenu extends Layout
{

    protected string $template = 'platform::layouts.tabMenu';

    /**
     * @throws \Throwable
     */
    public function build(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
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
