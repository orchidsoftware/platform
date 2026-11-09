<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Columns.
 *
 * @phpstan-consistent-constructor
 */
class Columns extends Layout
{
    public static function make(array $layouts = []): static
    {
        return new static($layouts);
    }

    /**
     * @var string
     */
    protected $template = 'orchid::layouts.columns';

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
     * @return mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }
}
