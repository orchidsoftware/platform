<?php

declare(strict_types=1);

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

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
 * @method $this max($value = true)
 * @method $this maxlength($value = true)
 * @method $this min($value = true)
 * @method $this multiple($value = true)
 * @method $this name($value = true)
 * @method $this pattern($value = true)
 * @method $this placeholder($value = true)
 * @method $this readonly($value = true)
 * @method $this required($value = true)
 * @method $this size($value = true)
 * @method $this src($value = true)
 * @method $this step($value = true)
 * @method $this tabindex($value = true)
 * @method $this type($value = true)
 * @method $this value($value = true)
 * @method $this help($value = true)
 */
class TagsField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.tags';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'    => 'form-control select2-tags',
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
     * @param $name
     *
     * @return string
     */
    public function modifyName($name)
    {
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');
        $name .= '[]';

        $this->attributes['name'] = $name;

        if (!is_null($prefix)) {
            $this->attributes['name'] = $prefix.$name;
        }

        if (is_null($prefix) && !is_null($lang)) {
            $this->attributes['name'] = $lang.$name;
        }

        if (!is_null($prefix) && !is_null($lang)) {
            $this->attributes['name'] = $prefix.'['.$lang.']'.$name;
        }

        if ($name instanceof \Closure) {
            $this->attributes['name'] = $name($this->attributes);
        }

        return $this;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function modifyValue($value)
    {
        $old = $this->getOldValue();

        $this->attributes['value'] = $value;

        if (is_array($value)) {
            $this->attributes['value'] = implode(',', $value);
        }

        if (!is_null($old)) {
            $this->attributes['value'] = $old;
        }

        if ($value instanceof \Closure) {
            $this->attributes['value'] = $value($this->attributes);
        }

        return $this;
    }
}
