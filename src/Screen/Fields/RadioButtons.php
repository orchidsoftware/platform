<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class RadioButtons.
 *
 * @method RadioButtons accesskey($value = true)
 * @method RadioButtons autofocus($value = true)
 * @method RadioButtons disabled($value = true)
 * @method RadioButtons form($value = true)
 * @method RadioButtons name(string $value = null)
 * @method RadioButtons required(bool $value = true)
 * @method RadioButtons size($value = true)
 * @method RadioButtons tabindex($value = true)
 * @method RadioButtons help(string $value = null)
 * @method RadioButtons popover(string $value = null)
 * @method RadioButtons title(string $value = null)
 * @method RadioButtons options(array $value = [])
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

    public function declarateActive(): self
    {
        return $this->set('active', fn (string $key, ?string $value = null) => $key === $value);
    }
}
