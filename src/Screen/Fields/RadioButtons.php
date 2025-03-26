<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class RadioButtons.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this name(string $value = null)
 * @method $this required(bool $value = true)
 * @method $this size($value = true)
 * @method $this tabindex($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
 * @method $this options(array $value = [])
 */
class RadioButtons extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.radiobutton';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'type'  => 'radio',
        'class' => 'btn-check',
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
        'required',
        'size',
        'tabindex',
        'type',
    ];

    /**
     * RadioButtons constructor.
     */
    public function __construct()
    {
        $this->declarateActive();
    }

    public function declarateActive(): static
    {
        return $this->set('active', fn (string $key, ?string $value = null) => $key === $value);
    }
}
