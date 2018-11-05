<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Builders;

use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\PropertyGenerator;

/**
 * Class Model.
 */
class Model extends Builder
{
    const RELATIONS = [
        'hasOne' => 'One to One (hasOne)',
        'hasMany' => 'One to Many (hasMany)',
        'belongsToMany' => 'Many to Many (belongsToMany)',
        'hasManyThrough' => 'Has Many Through (belongsToMany)',
        'morphMany' => 'Polymorphic (morphMany)',
        'morphedByMany' => 'Many to Many Polymorphic (morphedByMany)',
    ];

    /**
     * @var array
     */
    private $constants = [
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
        'guarded' => [
            'comment' => 'The attributes that aren\'t mass assignabe.',
        ],
        'hidden' => [
            'comment' => 'The attributes that should be hidden for serialization.',
        ],
        'visible' => [
            'comment' => 'The attributes that should be visible in serialization.',
        ],
    ];

    /**
     * @return string
     */
    public function generate(): string
    {
        $this->class->setExtendedClass(\Illuminate\Database\Eloquent\Model::class);
        $this->class->setNamespaceName('App'); //app()->getNamespace()

        foreach ($this->parameters->get('property', []) as $property => $value) {
            $this->setProperty($property, $value, $this->property[$property]['comment']);
        }

        foreach ($this->parameters->get('relations', []) as $relation => $value) {
            $this->setRelation($relation, $value['type'], $value['local'], $value['related']);
        }

        $this->clearDefaultConstantTrash();

        $file = new FileGenerator();
        $file->setClass($this->class);

        return $file->generate();
    }

    /**
     * @param string $property
     * @param        $value
     * @param null $comment
     * @param string $docContent
     * @param string $docName
     *
     * @return $this
     */
    protected function setProperty(string $property, $value, $comment = null, $docContent = 'array', $docName = 'var'): self
    {
        if (! array_has($this->parameters, 'property.'.$property)) {
            return $this;
        }

        $tag = new Tag\GenericTag($docName, $docContent);
        $docBlock = new DocBlockGenerator($comment, null, [
            $tag,
        ]);

        $propertyObject = new PropertyGenerator($property, $value, PropertyGenerator::FLAG_PROTECTED);
        $propertyObject->setDocBlock($docBlock);

        $this->class->addPropertyFromGenerator($propertyObject);

        return $this;
    }

    /**
     * @param string $name
     * @param string $type
     * @param string|null $local
     * @param null $related
     *
     * @return \Orchid\Bulldozer\Builders\Model
     */
    public function setRelation(string $name, string $type, string $local = null, $related = null): self
    {
        $params = [];

        if (! is_null($local) || ! is_null($related)) {
            $params[] = "'$local'";
        }

        if (! is_null($related)) {
            $params[] = "'$related'";
        }

        $params = implode(',', $params);

        if (! empty($params)) {
            $params = ','.$params;
        }

        $method = new MethodGenerator(
            $name,
            [],
            MethodGenerator::FLAG_PUBLIC,
            'return $this->'.$type.'('.$name.'::class'.$params.');',
            DocBlockGenerator::fromArray([
                'shortDescription' => 'Generated attitude',
                'longDescription' => null,
                'tags' => [
                    new Tag\ReturnTag([
                        'datatype' => "\Illuminate\Database\Eloquent\Relations\\".$type,
                    ]),
                ],
            ])
        );

        $this->class->addMethodFromGenerator($method);

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
