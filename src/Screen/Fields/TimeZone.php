<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use DateTimeZone;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

/**
 * Class TimeZone.
 *
* @method static autofocus($value = true)
* @method static disabled($value = true)
* @method static form($value = true)
* @method static name(string $value = null)
* @method static required(bool $value = true)
* @method static tabindex($value = true)
* @method static help(string $value = null)
* @method static popover(string $value = null)
* @method static title(string $value = null)
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
