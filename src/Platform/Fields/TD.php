<?php

declare(strict_types=1);

namespace Orchid\Platform\Platform\Fields;

use Closure;

class TD
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $width;

    /**
     * @var \Closure
     */
    public $render;

    /**
     * TD constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     *
     * @return TD
     */
    public static function name(string $name)
    {
        return new self($name);
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $width
     *
     * @return $this
     */
    public function width(string $width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param \Closure $closure
     *
     * @return $this
     */
    public function setRender(Closure $closure)
    {
        $this->render = $closure;

        return $this;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function handler($data)
    {
        return ($this->render)($data);
    }
}
