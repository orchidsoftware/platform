<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * @deprecated
 */
class Rubbers extends Layout
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.rubbers';

    /**
     * Layout constructor.
     *
     * @param Layout[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
    }

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }
}
