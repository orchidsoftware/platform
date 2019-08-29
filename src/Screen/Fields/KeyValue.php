<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

class KeyValue extends Field
{

    /**
     * @var string
     */
    protected $view = 'platform::fields.keyvalue';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'columns' => [
            'key',
            'value'
        ],
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }
}
