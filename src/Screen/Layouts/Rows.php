<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Builder;
use Orchid\Screen\Field;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Throwable;

/**
 * Class Rows.
 */
abstract class Rows extends Layout
{

    protected string $template = 'platform::layouts.row';

    /**
     * Used to create the title of a group of form elements.
     */
    protected ?string $title = null;

    protected Repository $query;

    /**
     * @param Repository $repository
     * @return View|null
     * @throws Throwable
     */
    public function build(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $form = new Builder($this->fields(), $repository);

        return view($this->template, [
            'form'  => $form->generateForm(),
            'title' => $this->title,
        ]);
    }

    public function title(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return iterable<Field>|iterable<string>
     */
    abstract protected function fields(): iterable;
}
