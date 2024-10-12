<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class SimpleMDE.
 *
 * @method SimpleMDE accesskey($value = true)
 * @method SimpleMDE autofocus($value = true)
 * @method SimpleMDE disabled($value = true)
 * @method SimpleMDE form($value = true)
 * @method SimpleMDE formaction($value = true)
 * @method SimpleMDE formenctype($value = true)
 * @method SimpleMDE formmethod($value = true)
 * @method SimpleMDE formnovalidate($value = true)
 * @method SimpleMDE formtarget($value = true)
 * @method SimpleMDE name(string $value = null)
 * @method SimpleMDE placeholder(string $value = null)
 * @method SimpleMDE readonly($value = true)
 * @method SimpleMDE required(bool $value = true)
 * @method SimpleMDE tabindex($value = true)
 * @method SimpleMDE value($value = true)
 * @method SimpleMDE help(string $value = null)
 * @method SimpleMDE popover(string $value = null)
 * @method SimpleMDE title(string $value = null)
 */
class SimpleMDE extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.simplemde';

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
        'placeholder',
        'readonly',
        'required',
        'tabindex',
    ];
}
