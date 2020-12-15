<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class UTM.
 *
 * @method UTM form($value = true)
 * @method UTM formaction($value = true)
 * @method UTM formenctype($value = true)
 * @method UTM formmethod($value = true)
 * @method UTM formnovalidate($value = true)
 * @method UTM formtarget($value = true)
 * @method UTM name(string $value = null)
 * @method UTM placeholder(string $value = null)
 * @method UTM required(bool $value = true)
 * @method UTM tabindex($value = true)
 * @method UTM value($value = true)
 * @method UTM help(string $value = null)
 * @method UTM popover(string $value = null)
 * @method UTM title(string $value = null)
 * @method UTM pattern($value = true)
 */
class UTM extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.utm';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'type'  => 'url',
        'class' => 'form-control',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accesskey',
        'autocomplete',
        'autofocus',
        'disabled',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'name',
        'pattern',
        'placeholder',
        'readonly',
        'required',
        'tabindex',
        'value',
    ];
}
