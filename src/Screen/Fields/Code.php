<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Input.
 *
 * @method $this name(string $value = null)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this language($value = true)
 * @method $this lineNumbers($value = true)
 * @method $this height($value = '300px')
 * @method $this readonly($value = true)
 * @method $this title(string $value = null)
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
