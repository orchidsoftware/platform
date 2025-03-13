<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

/**
 * Class Cropper.
 *
 * @method $this accept($value = true)
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this formaction($value = true)
 * @method $this formenctype($value = true)
 * @method $this formmethod($value = true)
 * @method $this formnovalidate($value = true)
 * @method $this formtarget($value = true)
 * @method $this name(string $value = null)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required(bool $value = true)
 * @method $this step($value = true)
 * @method $this tabindex($value = true)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this width($value = true)
 * @method $this height($value = true)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
 * @method $this maxFileSize($value = true)
 * @method $this storage($value = null)
 * @method $this staticBackdrop($value = false)
 * @method $this maxSizeValidateMessage($value = true)
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
        'imageSmoothingEnabled'  => true,
        'imageSmoothingQuality'  => 'medium',
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
    public function minWidth(int $width): static
    {
        $this->set('minWidth', $width);

        return $this;
    }

    /**
     * Set the minimum height of the resized image.
     */
    public function minHeight(int $height): static
    {
        $this->set('minHeight', $height);

        return $this;
    }

    /**
     * Set the maximum width of the resized image.
     */
    public function maxWidth(int $width): static
    {
        $this->set('maxWidth', $width);

        return $this;
    }

    /**
     * Set the maximum height of the resized image.
     */
    public function maxHeight(int $height): static
    {
        $this->set('maxHeight', $height);

        return $this;
    }

    /**
     * Set the minimum with and height of the resized image.
     */
    public function minCanvas(int $size): static
    {
        $this->set('minWidth', $size);
        $this->set('minHeight', $size);

        return $this;
    }

    /**
     * Set the maximum with and height of the resized image.
     */
    public function maxCanvas(int $size): static
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
    public function keepOriginalType(bool $keep = true): static
    {
        $this->set('keepOriginalType', $keep);

        return $this;
    }

    /**
     * Enables or disables image smoothing.
     *
     * @param bool $enabled - Whether to enable image smoothing.
     */
    public function imageSmoothingEnabled(bool $enabled = true): static
    {
        $this->set('imageSmoothingEnabled', $enabled);

        return $this;
    }

    /**
     * Sets the quality of image smoothing.
     *
     * Accepts values: 'low', 'medium', 'high'.
     * Defaults to 'medium'.
     *
     * @param string $quality The quality of image smoothing.
     *
     * @return static
     */
    public function imageSmoothingQuality(string $quality = 'medium'): static
    {
        $this->set('imageSmoothingQuality', $quality);

        return $this;
    }
}
