<?php

namespace Orchid\Foundation\Services\Type;

abstract class Type implements TypeInterface
{
    /**
     * Name type.
     * @var
     */
    public $name = '';


    /**
     * @var string
     */
    public $slug = '';

    /**
     * @var string
     */
    public $icon = 'ion-ios-paper-outline';

    /**
     * Fields for content.
     * @var array
     */
    public $fields = [];


    /**
     * Relations.
     * @var
     */
    public $relations = [];


    /**
     * Available templates.
     * @var
     */
    public $templates = [];


    /**
     * To determine the properties by the function.
     * @var array
     */
    private $method = [
        'setName',
        'setRelations',
        'setTemplates',
    ];

    /**
     * Type constructor.
     */
    public function __construct()
    {
        $arg = func_get_args();
        $this->setForm($arg);

        foreach ($this->method as $value) {
            if (method_exists($this, $value)) {
                $this->$value();
            }
        }
    }

    /**
     * @param array ...$arg
     */
    public function setForm(...$arg)
    {
    }
}
