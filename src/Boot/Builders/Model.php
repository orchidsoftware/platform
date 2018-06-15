<?php

declare(strict_types=1);

namespace Orchid\Boot\Builders;

use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\PropertyGenerator;

/**
 * Class Model.
 */
class Model
{
    const RELATIONS = [
        'hasOne'         => 'One to One (hasOne)',
        'hasMany'        => 'One to Many (hasMany)',
        'belongsToMany'  => 'Many to Many (belongsToMany)',
        'hasManyThrough' => 'Has Many Through (belongsToMany)',
        'morphMany'      => 'Polymorphic (morphMany)',
        'morphedByMany'  => 'Many to Many Polymorphic (morphedByMany)',
    ];

    /**
     * @var ClassGenerator
     */
    protected $class;

    /**
     * @var array
     */
    protected $constants = [
        'CREATED_AT' => 'created_at',
        'UPDATED_AT' => 'updated_at',
    ];

    /**
     * @var array
     */
    protected $property = [
        'fillable' => [
            'comment' => 'The attributes that are mass assignable.',
        ],
        'guarded'  => [
            'comment' => 'The attributes that aren\'t mass assignabe.',
        ],
        'hidden'   => [
            'comment' => 'The attributes that should be hidden for serialization.',
        ],
        'visible'  => [
            'comment' => 'The attributes that should be visible in serialization.',
        ],
    ];

    /**
     * @var
     */
    protected $parameters;

    /**
     * Model constructor.
     * @param null  $class
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
    public function setParameters($parameters)
    {
        $this->parameters = collect($parameters);

        return $this;
    }

    public function methodHasMany()
    {
    }

    public function methodHasOne()
    {
    }

    public function methodBelongsTo()
    {
    }

    public function methodBelongsToMany()
    {
    }

    /**
     * @return string
     */

    /**
     * @return string
     */
    public function generate()
    {
        $this->class->setExtendedClass(\Illuminate\Database\Eloquent\Model::class);
        $this->class->setNamespaceName('App\Models');

        foreach ($this->parameters->get('property', []) as $property => $value) {
            $this->setProperty($property, $value, $this->property[$property]['comment']);
        }

        $this->clearDefaultConstantTrash();

        return $this->class->generate();
    }

    /**
     * @param string $property
     * @param        $value
     * @param null   $comment
     * @param string $docContent
     * @param string $docName
     * @return $this
     */
    protected function setProperty(string $property, $value, $comment = null, $docContent = 'array', $docName = 'var')
    {
        if (! array_has($this->parameters, 'property.'.$property)) {
            return $this;
        }

        $tag = new Tag\GenericTag($docName, $docContent);
        $docblock = new DocBlockGenerator($comment, null, [
            $tag,
        ]);

        $property = new PropertyGenerator($property, $value, PropertyGenerator::FLAG_PROTECTED);
        $property->setDocBlock($docblock);

        $this->class->addPropertyFromGenerator($property);

        return $this;
    }

    /**
     * @return Model
     */
    private function clearDefaultConstantTrash(): self
    {
        foreach ($this->class->getConstants() as $constant) {
            if ($this->constants[$constant->getName()] === $constant->getDefaultValue()->getValue()) {
                $this->class->removeConstant($constant->getName());
            }
        }

        return $this;
    }
}
