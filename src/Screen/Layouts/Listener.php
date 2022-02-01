<?php

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Builder;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

abstract class Listener extends Layout
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.listener';

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'name',
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * @var string
     */
    protected $asyncMethod;

    /**
     * The following request must be asynchronous.
     *
     * @var bool
     */
    protected $asyncNext = true;

    /**
     * @var Repository
     */
    public $query;

    /**
     * @return array
     */
    abstract protected function layouts(): iterable;

    /**
     * @param Repository $repository
     *
     * @return mixed|void
     */
    public function build(Repository $repository)
    {
        if (! $this->isSee()) {
            return;
        }

        $this->query = $repository;
        $this->layouts = $this->layouts();
        $this->variables['targets'] = collect($this->targets)->map(function ($target) {
            return Builder::convertDotToArray($target);
        })->toJson();

        return $this->buildAsDeep($repository);
    }

    /**
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return sha1(static::class);
    }
}
