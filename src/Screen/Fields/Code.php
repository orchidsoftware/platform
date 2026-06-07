<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Code.
 *
 * @method $this name(string $value = null)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this language($value = true)
 * @method $this lineNumbers($value = true)
 * @method $this height($value = '300px')
 * @method $this readonly($value = true)
 * @method $this placeholder(string $value = null)
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
    protected $view = 'orchid::fields.code';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'       => 'form-control',
        'language'    => self::JS,
        'lineNumbers' => true,
        'height'      => '300px',
        'value'       => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'name',
        'placeholder',
        'readonly',
        'required',
        'tabindex',
        'value',
        'language',
        'lineNumbers',
        'height',
    ];

    /**
     * Markup constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            $value = $this->get('value');

            if ($value === null || is_string($value)) {
                return;
            }

            $this->set('value', json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        });
    }
}
