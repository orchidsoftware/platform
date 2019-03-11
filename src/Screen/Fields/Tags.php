<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Tags.
 *
 * @method self accept($value = true)
 * @method self accesskey($value = true)
 * @method self autocomplete($value = true)
 * @method self autofocus($value = true)
 * @method self checked($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self formaction($value = true)
 * @method self formenctype($value = true)
 * @method self formmethod($value = true)
 * @method self formnovalidate($value = true)
 * @method self formtarget($value = true)
 * @method self list($value = true)
 * @method self max(int $value)
 * @method self maxlength(int $value)
 * @method self min(int $value)
 * @method self multiple($value = true)
 * @method self name(string $value)
 * @method self pattern($value = true)
 * @method self placeholder(string $value = null)
 * @method self readonly($value = true)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self src($value = true)
 * @method self step($value = true)
 * @method self tabindex($value = true)
 * @method self type($value = true)
 * @method self value($value = true)
 * @method self help(string $value = null)
 * @method self popover(string $value = null)
 */
class Tags extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.tags';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'    => 'form-control',
        'multiple' => 'multiple',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accept',
        'accesskey',
        'autocomplete',
        'autofocus',
        'checked',
        'disabled',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'list',
        'max',
        'maxlength',
        'min',
        'multiple',
        'name',
        'pattern',
        'placeholder',
        'readonly',
        'required',
        'size',
        'src',
        'step',
        'tabindex',
        'type',
        'value',
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

    /**
     * @param string|\Closure $name
     *
     * @return \Orchid\Screen\Field|void
     */
    public function modifyName($name)
    {
        if (substr($name, -1) !== '.') {
            $this->attributes['name'] = $name.'[]';
        }

        parent::modifyName($this->attributes['name']);
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function modifyValue($value) : Field
    {
        if (is_string($value)) {
            $this->attributes['value'] = explode(',', $value);
        }

        if ($value instanceof \Closure) {
            $this->attributes['value'] = $value($this->attributes);
        }

        if (is_null($value)) {
            $this->attributes['value'] = [];
        }

        return $this;
    }
}
