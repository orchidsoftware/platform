<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Layouts\Base;

abstract class Content extends Base
{
    /**
     * @var Repository|null
     */
    protected $query;

    /**
     * Key property for query
     *
     * @var mixed
     */
    protected $target;

    /**
     * Card constructor.
     *
     * @param mixed $target
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * @param Repository $repository
     *
     * @return string
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (is_string($this->target) || is_array($this->target)) {
            $this->target = $repository->get($this->target);
        }

        return (string)$this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->render($this->target);
    }
}
