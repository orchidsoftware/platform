<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class TagsField.
 *
 * @method $this accept($value = true)
 * @method $this accesskey($value = true)
 * @method $this autocomplete($value = true)
 * @method $this autofocus($value = true)
 * @method $this checked($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this formaction($value = true)
 * @method $this formenctype($value = true)
 * @method $this formmethod($value = true)
 * @method $this formnovalidate($value = true)
 * @method $this formtarget($value = true)
 * @method $this list($value = true)
 * @method $this max(int $value)
 * @method $this maxlength($value = true)
 * @method $this min(int $value)
 * @method $this multiple($value = true)
 * @method $this name(string $value)
 * @method $this pattern($value = true)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required($value = true)
 * @method $this size($value = true)
 * @method $this src($value = true)
 * @method $this step($value = true)
 * @method $this tabindex($value = true)
 * @method $this type($value = true)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 */
class TagsField extends Field
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
     * @return TagsField
     */
    public static function make(string $name = null): self
    {
        return (new static)->name($name);
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
     * @return mixed
     */
    public function modifyValue($value)
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
