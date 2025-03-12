<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class UTM.
 *
 * @method static form($value = true)
 * @method static formaction($value = true)
 * @method static formenctype($value = true)
 * @method static formmethod($value = true)
 * @method static formnovalidate($value = true)
 * @method static formtarget($value = true)
 * @method static name(string $value = null)
 * @method static placeholder(string $value = null)
 * @method static required(bool $value = true)
 * @method static tabindex($value = true)
 * @method static value($value = true)
 * @method static help(string $value = null)
 * @method static popover(string $value = null)
 * @method static title(string $value = null)
 * @method static pattern($value = true)
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
