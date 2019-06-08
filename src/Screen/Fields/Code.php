<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Input.
 *
 * @method self name(string $value = null)
 * @method self value($value = true)
 * @method self help(string $value = null)
 * @method self popover(string $value = null)
 * @method self language($value = true)
 * @method self lineNumbers($value = true)
 * @method self height($value = '300px')
 * @method self readonly($value = true)
 */
class Code extends Field
{
    /**
     * Supported language.
     *
     * markup, html, xml, svg, mathml
     */
    public const MARKUP = 'markup';

    /**
     * Supported language.
     */
    public const CSS = 'css';

    /**
     * Supported language.
     */
    public const CLIKE = 'clike';

    /**
     * Supported language.
     *
     * javascript, js
     */
    public const JS = 'js';

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
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function modifyValue($value) : Field
    {
        $value = parent::modifyValue($value);

        if ($this->get('language') === 'json') {
            $value = json_encode($value);
        }

        return $value;
    }
}
