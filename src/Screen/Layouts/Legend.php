<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\Sight;

/**
 * Class Legend.
 */
abstract class Legend extends Layout
{
    protected string $template = 'platform::layouts.legend';

    /**
     * Used to create the title of a group of form elements.
     */
    protected ?string $title = null;

    protected Repository $query;

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     */
    protected string $target;

    public function build(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $columns = collect($this->columns())->filter(static fn (Sight $sight) => $sight->isSee());

        $repository = $this->target
            ? $repository->getContent($this->target)
            : $repository;

        return view($this->template, [
            'repository' => $repository,
            'columns'    => $columns,
            'slug'       => $this->getSlug(),
            'title'      => $this->title,
        ]);
    }

    /**
     * @return array
     */
    abstract protected function columns(): iterable;

    public function title(?string $title = null): static
    {
        $this->title = $title;

        return $this;
    }
}
