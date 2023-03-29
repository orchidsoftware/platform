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
    protected $targets = [];

    /**
     * @return array
     */
    abstract protected function layouts(): iterable;

    /**
     * @return mixed|void
     */
    public function build(Repository $repository)
    {
        if (! $this->isSee()) {
            return;
        }

        $this->query = $repository;
        $this->layouts = $this->layouts();

        $this->variables['targets'] = collect($this->targets)->map(fn ($target) => Builder::convertDotToArray($target))->toJson();
        $this->variables['extraVars'] = json_encode([]);

        return $this->buildAsDeep($repository);
    }

    /**
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     */
    public function getSlug(): string
    {
        return sha1(static::class);
    }
}
