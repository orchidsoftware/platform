<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

/**
 * Class Cropper.
 *
 * @method Cropper accept($value = true)
 * @method Cropper accesskey($value = true)
 * @method Cropper autofocus($value = true)
 * @method Cropper disabled($value = true)
 * @method Cropper form($value = true)
 * @method Cropper formaction($value = true)
 * @method Cropper formenctype($value = true)
 * @method Cropper formmethod($value = true)
 * @method Cropper formnovalidate($value = true)
 * @method Cropper formtarget($value = true)
 * @method Cropper name(string $value = null)
 * @method Cropper placeholder(string $value = null)
 * @method Cropper readonly($value = true)
 * @method Cropper required(bool $value = true)
 * @method Cropper step($value = true)
 * @method Cropper tabindex($value = true)
 * @method Cropper value($value = true)
 * @method Cropper help(string $value = null)
 * @method Cropper width($value = true)
 * @method Cropper height($value = true)
 * @method Cropper popover(string $value = null)
 * @method Cropper title(string $value = null)
 * @method Cropper maxFileSize($value = true)
 */
class Cropper extends Picture
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.cropper';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'value'       => null,
        'target'      => 'url',
        'url'         => null,
        'width'       => null,
        'height'      => null,
        'maxFileSize' => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accept',
        'accesskey',
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
        'step',
        'tabindex',
        'value',
        'target',
        'url',
    ];
}
