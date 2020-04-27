<?php

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

abstract class Listener extends Base
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.listener';

    /**
     * @var string[]
     */
    protected $targets = [
        'name'
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
     * Listener constructor.
     */
    public function __construct()
    {
        $this->layouts[] = Layout::view('hello');
    }

    /**
     * @return array
     */
    abstract protected function layouts(): array;

    /**
     * @param Repository $repository
     *
     * @return mixed|void
     */
    public function build(Repository $repository)
    {
        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        $this->query = $repository;
        $this->layouts = $this->layouts();
        $this->variables['targets'] = json_encode($this->targets);

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
