<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use DateTimeZone;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

/**
 * Class TimeZone.
 *
 * @method TimeZone autofocus($value = true)
 * @method TimeZone disabled($value = true)
 * @method TimeZone form($value = true)
 * @method TimeZone name(string $value = null)
 * @method TimeZone required(bool $value = true)
 * @method TimeZone tabindex($value = true)
 * @method TimeZone help(string $value = null)
 * @method TimeZone popover(string $value = null)
 * @method TimeZone title(string $value = null)
 */
class TimeZone extends Field
{
    use Multipliable;

    /**
     * @var string
     */
    protected $view = 'platform::fields.select';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'        => 'form-control',
        'options'      => [],
        'allowEmpty'   => 0,
        'allowAdd'     => false,
        'isOptionList' => false,
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
    ];

    /**
     * TimeZone constructor.
     */
    public function __construct()
    {
        $this->listIdentifiers();

        $this->addBeforeRender(function () {
            $isOptionList = array_is_list((array) $this->get('options', []));
            $this->set('isOptionList', $isOptionList);
        });
    }

    public function listIdentifiers(int $time = DateTimeZone::ALL): self
    {
        $timeZone = collect(DateTimeZone::listIdentifiers($time))
            ->mapWithKeys(static fn ($timezone) => [$timezone => $timezone])->toArray();

        $this->set('options', $timeZone);

        return $this;
    }
}
