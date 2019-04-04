<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Wrapper.
 */
abstract class Wrapper extends Base
{
    /**
     * @var string
     */
    public $template;

    /**
     * Wrapper constructor.
     *
     * @param string $template
     * @param Base[] $layouts
     */
    public function __construct(string $template, array $layouts = [])
    {
        $this->template = $template;
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
