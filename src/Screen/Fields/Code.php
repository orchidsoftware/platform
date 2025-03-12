<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Input.
 *
 * @method static name(string $value = null)
 * @method static value($value = true)
 * @method static help(string $value = null)
 * @method static popover(string $value = null)
 * @method static language($value = true)
 * @method static lineNumbers($value = true)
 * @method static height($value = '300px')
 * @method static readonly($value = true)
 * @method static title(string $value = null)
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
