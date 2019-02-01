<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class InputField.
 *
 * @method $this name(string $value)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this language($value = true)
 * @method $this lineNumbers($value = true)
 * @method $this height($value = '300px')
 */
class CodeField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.code';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'        => 'form-control',
        'language'     => 'js',
        'lineNumbers'  => true,
        'defaultTheme' => true,
        'height'       => '300px',
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
        'language',
        'lineNumbers',
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
        'height',
    ];

    /**
     * @param string $name
     * @return CodeField
     */
    public static function make(string $name = null): self
    {
        return (new static)->name($name);
    }

    /**
     * @param mixed $value
     *
     * @return \Orchid\Screen\Field
     */
    public function modifyValue($value)
    {
        $value = parent::modifyValue($value);

        if ($this->get('language') === 'json') {
            $value = json_encode($value);
        }

        return $value;
    }
}
