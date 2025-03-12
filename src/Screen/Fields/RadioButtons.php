<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class RadioButtons.
 *
* @method statics accesskey($value = true)
* @method statics autofocus($value = true)
* @method statics disabled($value = true)
* @method statics form($value = true)
* @method statics name(string $value = null)
* @method statics required(bool $value = true)
* @method statics size($value = true)
* @method statics tabindex($value = true)
* @method statics help(string $value = null)
* @method statics popover(string $value = null)
* @method statics title(string $value = null)
* @method statics options(array $value = [])
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
