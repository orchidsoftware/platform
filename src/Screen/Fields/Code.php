<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Input.
 *
 * @method Code name(string $value = null)
 * @method Code value($value = true)
 * @method Code help(string $value = null)
 * @method Code popover(string $value = null)
 * @method Code language($value = true)
 * @method Code lineNumbers($value = true)
 * @method Code height($value = '300px')
 * @method Code readonly($value = true)
 * @method Code title(string $value = null)
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
    protected $view = 'platform::fields.code';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
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
    protected $inlineAttributes = [
        'accesskey',
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
        'name',
        'placeholder',
        'readonly',
        'required',
        'tabindex',
        'value',
        'height',
    ];

    /**
     * Code constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            if ($this->get('language') === 'json') {
                $value = $this->get('value');
                $this->set('value', json_encode($value));
            }
        });
    }
}
