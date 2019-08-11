<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;
use Illuminate\Contracts\View\Factory;

/**
 * Class Metric.
 */
abstract class Metric extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.metric';

    /**
     * @var string
     */
    public $title = 'Example Metric';

    /**
     * @var array
     */
    public $labels = [];

    /**
     * @var string
     */
    public $target;

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
