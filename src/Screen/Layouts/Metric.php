<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Orchid\Screen\Repository;

/**
 * Class Metric.
 */
abstract class Metric extends Base
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.metric';

    /**
     * @var string
     */
    protected $title = 'Example Metric';

    /**
     * Set the labels for each possible field value.
     *
     * @var array
     */
    protected $labels = [];

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the metric.
     *
     * @var string
     */
    protected $target;

    /**
     * @var string
     */
    protected $keyValue = 'value';

    /**
     * @var string
     */
    protected $keyDiff = 'diff';

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

        $data = $repository->getContent($this->target, []);
        $metrics = array_combine($this->labels, $data);

        return view($this->template, [
            'title'    => __($this->title),
            'metrics'  => $metrics,
            'keyValue' => $this->keyValue,
            'keyDiff'  => $this->keyDiff,
        ]);
    }
}
