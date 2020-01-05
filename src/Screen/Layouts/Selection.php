<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Orchid\Filters\Filter;
use Orchid\Screen\Repository;

/**
 * Class Selection.
 */
abstract class Selection extends Base
{
    /**
     * Drop down filters.
     */
    public const TEMPLATE_DROP_DOWN = 'platform::layouts.selection';

    /**
     * Line filters.
     */
    public const TEMPLATE_LINE = 'platform::layouts.filter';

    /**
     * @var string
     */
    public $template = self::TEMPLATE_DROP_DOWN;

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View|mixed
     */
    public function build(Repository $repository)
    {
        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        $filters = collect($this->filters());
        $count = $filters->count();

        if ($count === 0) {
            return;
        }

        $filters = $filters->map(static function ($filter) {
            return app()->make($filter);
        });

        return view($this->template, [
            'filters' => $filters,
            'chunk'   => ceil($count / 4),
        ]);
    }

    /**
     * @return Filter[]
     */
    abstract public function filters(): array;
}
