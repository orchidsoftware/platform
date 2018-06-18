<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Builders;

use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\PropertyGenerator;

abstract class Builder
{
    /**
     * @var ClassGenerator
     */
    protected $class;

    /**
     * @var
     */
    protected $parameters;

    /**
     * Class constructor.
     *
     * @param string  $class
     * @param array $parameters
     * @throws \ReflectionException
     */
    public function __construct($class = null, array $parameters = [])
    {
        $this->parameters = collect($parameters);

        if (! class_exists($class)) {
            $this->class = new ClassGenerator();
            $this->class->setName($class);

            return;
        }
        $reflection = new ClassReflection($class);
        $this->class = ClassGenerator::fromReflection($reflection);
    }

    /**
     * @param $parameters
     * @return $this
     */
    public function setParameters($parameters) : self
    {
        $this->parameters = collect($parameters);

        return $this;
    }

    /**
     * @return string
     */
    abstract function generate(): string ;
}