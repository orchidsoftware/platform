<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use DateTimeZone;
use Illuminate\Support\Arr;
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
    protected $view = 'orchid::fields.select';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'            => 'form-control',
        'options'          => [],
        'allowEmpty'       => 0,
        'allowCreate'      => false,
        'isOptionList'     => false,
        'isLazy'           => false,
        'selectedValues'   => [],
        'allowEmptyValue'  => 'false',
        'allowCreateValue' => 'false',
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
            $this
                ->set('isOptionList', array_is_list((array) $this->get('options', [])))
                ->set('selectedValues', $this->selectedValues())
                ->set('allowEmptyValue', var_export((bool) $this->get('allowEmpty'), true))
                ->set('allowCreateValue', var_export((bool) $this->get('allowCreate'), true));
        });
    }

    public function listIdentifiers(int $time = DateTimeZone::ALL): static
    {
        return $this->set('options', collect(DateTimeZone::listIdentifiers($time))
            ->mapWithKeys(static fn ($timezone) => [$timezone => $timezone])
            ->toArray());
    }

    /**
     * Values selected in eager mode, normalized for strict Blade checks.
     *
     * @return array<int, string>
     */
    private function selectedValues(): array
    {
        return collect(Arr::wrap($this->get('value', [])))
            ->map(static fn ($item): string => (string) $item)
            ->all();
    }
}
