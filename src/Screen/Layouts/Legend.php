<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\Sight;

/**
 * Class Legend.
 *
 * @phpstan-consistent-constructor
 */
class Legend extends Layout
{
    public function __construct(protected array $columns = []) {}

    public static function make(array $columns = []): static
    {
        return new static($columns);
    }

    /**
     * @var string
     */
    protected $template = 'orchid::layouts.legend';

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
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target;

    public function target(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return Factory|View|null
     */
    public function build(Repository $repository)
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
    protected function columns(): iterable
    {
        return $this->columns;
    }

    public function title(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }
}
