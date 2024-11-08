<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

/**
 * Class Select.
 *
 * @method Select accesskey($value = true)
 * @method Select autofocus($value = true)
 * @method Select disabled($value = true)
 * @method Select form($value = true)
 * @method Select name(string $value = null)
 * @method Select required(bool $value = true)
 * @method Select size($value = true)
 * @method Select tabindex($value = true)
 * @method Select help(string $value = null)
 * @method Select popover(string $value = null)
 * @method Select options($value = null)
 * @method Select title(string $value = null)
 * @method Select maximumSelectionLength(int $value = 0)
 * @method Select allowAdd($value = true)
 */
class Select extends Field implements ComplexFieldConcern
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
        'allowEmpty'   => '',
        'allowAdd'     => false,
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
        'placeholder',
        'size',
        'tabindex',
        'tags',
        'maximumSelectionLength',
    ];

    /**
     * Populate the select options from an Eloquent model.
     *
     * @param Model|string $model The model class or instance to fetch options from.
     * @param string       $name  The attribute to use as the display name.
     * @param string|null  $key   Optional. The key attribute (e.g., ID). Defaults to the model's primary key.
     *
     * @return self
     */
    public function fromModel(Model|string $model, string $name, ?string $key = null): self
    {
        $model = is_string($model) ? new $model : $model;

        $key = $key ?? $model->getKeyName();

        return $this->setFromEloquent($model, $name, $key);
    }

    /**
     * Populate the select options from a PHP Enum.
     *
     * @param string      $enum        The fully-qualified name of the enum class.
     * @param string|null $displayName Optional. The method or property to use as the display name. Defaults to the enum case name.
     *
     * @throws \ReflectionException
     *
     * @return self
     */
    public function fromEnum(string $enum, ?string $displayName = null): self
    {
        $reflection = new \ReflectionEnum($enum);

        $options = collect($enum::cases())
            ->mapWithKeys(fn (\UnitEnum $item) => [
                $reflection->isBacked() ? $item->value : $item->name => $displayName === null
                    ? __($item->name)
                    : $item->$displayName()
            ])
            ->toArray();

        $this->set('options', $options);

        return $this->addBeforeRender(function () use ($enum, $reflection) {
            $value = collect($this->get('value'))
                ->map(fn ($item) => $item instanceof $enum
                    ? ($reflection->isBacked() ? $item->value : $item->name)
                    : $item)
                ->toArray();

            $this->set('value', $value);
        });
    }

    /**
     * Set options from an Eloquent model or a collection of models.
     *
     * @param Model|Builder|Collection $model The Eloquent model or query builder to use.
     * @param string        $name  The attribute to use as the display name.
     * @param string        $key   The attribute to use as the key. Defaults to the model's primary key.
     *
     * @return self
     */
    private function setFromEloquent(Model|Builder|Collection $model, string $name, string $key): self
    {
        $options = $model->pluck($name, $key)->toArray();

        $this->set('options', $options);

        return $this->addBeforeRender(function () use ($name) {
            $value = collect($this->get('value'))
                ->map(fn ($item) => is_object($item) ? [$item->id => $item->$name] : $item)
                ->toArray();

            $this->set('value', $value);
        });
    }

    /**
     * Populate the select options from a query builder result.
     *
     * @param Builder     $builder The query builder to fetch options from.
     * @param string      $name    The attribute to use as the display name.
     * @param string|null $key     Optional. The key attribute (e.g., ID). Defaults to the model's primary key.
     *
     * @return self
     */
    public function fromQuery(Builder $builder, string $name, ?string $key = null): self
    {
        $key = $key ?? $builder->getModel()->getKeyName();

        return $this->setFromEloquent($builder->get(), $name, $key);
    }

    /**
     * Allow the Select field to have an empty (null) option.
     *
     * @param string $name The display name for the empty option.
     * @param string $key  The key to use for the empty option. Defaults to an empty string.
     *
     * @return self
     */
    public function empty(string $name = '', string $key = ''): self
    {
        return $this->addBeforeRender(function () use ($name, $key) {
            $options = collect($this->get('options', []))->toArray();

            $this->set('options', [$key => $name] + $options);
            $this->set('allowEmpty', '1');
        });
    }

    /**
     * Set the maximum number of items that may be selected.
     *
     * @return $this
     */
    public function max(int $number)
    {
        $this->set('data-maximum-selection-length', (string) $number);

        return $this;
    }

    /**
     * Allow empty value to be set
     *
     * @deprecated use `allowEmpty()` instead
     */
    public function nullable(bool $value = true): self
    {
        return $this->set('allowEmpty', $value);
    }
}
