<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Relationship.
 *
 * @method self accesskey($value = true)
 * @method self autofocus($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self multiple($value = true)
 * @method self name(string $value)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self tabindex($value = true)
 * @method self help(string $value = null)
 * @method self popover(string $value = null)
 * @method self handler($value = true)
 */
class Relationship extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.relationship';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
        'handler',
    ];

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'     => 'form-control',
        'value'     => null,
        'allowhtml' => 'false',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'multiple',
        'name',
        'required',
        'size',
        'tabindex',
        'placeholder',
        'allowhtml',
    ];

    /**
     * Do not sanitize option response from the widget.
     *
     * @return \Orchid\Screen\Fields\Relationship
     */
    public function allowHtml(): self
    {
        $this->set('allowhtml', 'true');

        return $this;
    }

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
