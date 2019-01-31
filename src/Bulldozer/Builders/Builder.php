<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Builders;

use Illuminate\Support\Collection;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Reflection\ClassReflection;

/**
 * Class Builder.
 */
abstract class Builder
{
    /**
     * @var ClassGenerator
     */
    protected $class;

    /**
     * @var Collection
     */
    protected $parameters;

    /**
     * Class constructor.
     *
     * @param string $class
     * @param array $parameters
     * @throws \ReflectionException
     */
    public function __construct($class = null, array $parameters = [])
    {
        $this->parameters = collect($parameters);

        if (! class_exists($class)) {
            $this->class = new ClassGenerator;
            $this->class->setName($class);

            return;
        }
        $reflection = new ClassReflection($class);
        $this->class = ClassGenerator::fromReflection($reflection);
    }

    /**
     * @param mixed $parameters
     * @return $this
     */
    public function setParameters($parameters): self
    {
        $this->parameters = collect($parameters);

        return $this;
    }

    /**
     * @return string
     */
    abstract public function generate(): string;
}
