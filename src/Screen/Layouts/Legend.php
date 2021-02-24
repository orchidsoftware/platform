<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\Sight;

/**
 * Class Legend.
 */
abstract class Legend extends Layout
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.legend';

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

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        $this->query = $repository;

        $columns = collect($this->columns())->filter(static function (Sight $sight) {
            return $sight->isSee();
        });

        $repository = $this->target
            ? $repository->getContent($this->target)
            : $repository;

        return view($this->template, [
            'repository' => $repository,
            'columns'    => $columns,
            'slug'       => $this->getSlug(),
        ]);
    }

    /**
     * @return array
     */
    abstract protected function columns(): array;
}
