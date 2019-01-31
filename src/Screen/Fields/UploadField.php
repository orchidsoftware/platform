<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class UploadField.
 *
 * @method $this accept($value = true)
 * @method $this accesskey($value = true)
 * @method $this autocomplete($value = true)
 * @method $this autofocus($value = true)
 * @method $this checked($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this formaction($value = true)
 * @method $this formenctype($value = true)
 * @method $this formmethod($value = true)
 * @method $this formnovalidate($value = true)
 * @method $this formtarget($value = true)
 * @method $this list($value = true)
 * @method $this max(int $value)
 * @method $this maxlength($value = true)
 * @method $this min(int $value)
 * @method $this multiple($value = true)
 * @method $this name(string $value)
 * @method $this pattern($value = true)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required($value = true)
 * @method $this size($value = true)
 * @method $this src($value = true)
 * @method $this step($value = true)
 * @method $this tabindex($value = true)
 * @method $this type($value = true)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this storage($value = true)
 * @method $this parallelUploads($value = true)
 * @method $this maxFileSize($value = true)
 * @method $this maxFiles($value = true)
 * @method $this acceptedFiles($value = true)
 * @method $this resizeQuality($value = true)
 * @method $this resizeWidth($value = true)
 * @method $this resizeHeight($value = true)
 * @method $this popover(string $value = null)
 * @method $this groups($value = true)
 */
class UploadField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.upload';

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    public $attributes = [
        'value'           => null,
        'multiple'        => true,
        'parallelUploads' => 10,
        'maxFileSize'     => 9999,
        'maxFiles'        => 9999,
        'acceptedFiles'   => null,
        'resizeQuality'   => 0.8,
        'resizeWidth'     => null,
        'resizeHeight'    => null,
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
        'groups',
        'storage',
    ];

    /**
     * @param null $name
     * @return UploadField
     */
    public static function make($name = null): self
    {
        return (new static)->name($name);
    }
}
