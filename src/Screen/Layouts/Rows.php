<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
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
    /**
     * @var string
     */
    protected $template = 'platform::layouts.row';

    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * @var Repository
     */
    protected $query;

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
     * @return Field[]
     */
    abstract protected function fields(): iterable;
}
