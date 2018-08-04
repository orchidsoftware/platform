<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields\Types;

use Orchid\Screen\Fields\Field;

/**
 * Class InputField.
 *
 * @method $this name($value = true)
 * @method $this value($value = true)
 * @method $this help($value = true)
 */
class CodeField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.code';

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
        'class'       => 'form-control',
        'language'    => 'js',
        'lineNumbers' => true,
        'defaultTheme' => true,
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
    ];
}
