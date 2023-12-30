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
 * @method Cropper storage($value = null)
 * @method Cropper staticBackdrop($value = false)
 * @method Cropper maxSizeValidateMessage($value = true)
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
        'value'                  => null,
        'target'                 => 'url',
        'url'                    => null,
        'width'                  => null,
        'height'                 => null,
        'minWidth'               => 0,
        'minHeight'              => 0,
        'maxWidth'               => 'Infinity',
        'maxHeight'              => 'Infinity',
        'maxFileSize'            => null,
        'staticBackdrop'         => false,
        'acceptedFiles'          => 'image/*',
        'keepOriginalType'       => false,
        'maxSizeValidateMessage' => 'The upload file is too large. Max size: {value} MB',
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
        'groups',
        'path',
    ];

    /**
     * Set the minimum with of the resized image.
     */
    public function minWidth(int $width): self
    {
        $this->set('minWidth', $width);

        return $this;
    }

    /**
     * Set the minimum height of the resized image.
     */
    public function minHeight(int $height): self
    {
        $this->set('minHeight', $height);

        return $this;
    }

    /**
     * Set the maximum width of the resized image.
     */
    public function maxWidth(int $width): self
    {
        $this->set('maxWidth', $width);

        return $this;
    }

    /**
     * Set the maximum height of the resized image.
     */
    public function maxHeight(int $height): self
    {
        $this->set('maxHeight', $height);

        return $this;
    }

    /**
     * Set the minimum with and height of the resized image.
     */
    public function minCanvas(int $size): self
    {
        $this->set('minWidth', $size);
        $this->set('minHeight', $size);

        return $this;
    }

    /**
     * Set the maximum with and height of the resized image.
     */
    public function maxCanvas(int $size): self
    {
        $this->set('maxWidth', $size);
        $this->set('maxHeight', $size);

        return $this;
    }

    /**
     * Set whether to keep the original image type.
     *
     * @param bool $keep Whether to keep the original image type.
     */
    public function keepOriginalType(bool $keep = true): self
    {
        $this->set('keepOriginalType', $keep);

        return $this;
    }
}
