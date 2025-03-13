<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use DateTimeZone;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

/**
 * Class TimeZone.
 *
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this name(string $value = null)
 * @method $this required(bool $value = true)
 * @method $this tabindex($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
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

    public function listIdentifiers(int $time = DateTimeZone::ALL): static
    {
        $timeZone = collect(DateTimeZone::listIdentifiers($time))
            ->mapWithKeys(static fn ($timezone) => [$timezone => $timezone])->toArray();

        $this->set('options', $timeZone);

        return $this;
    }
}
