<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;
use ReflectionEnum;
use ReflectionException;
use UnitEnum;

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

    protected string $view = 'platform::fields.select';

    /**
     * Default attributes value.
     */
    protected array $attributes = [
        'class'        => 'form-control',
        'options'      => [],
        'allowEmpty'   => '',
        'allowAdd'     => false,
        'isOptionList' => false,
    ];

    /**
     * Attributes available for a particular tag.
     */
    protected array $inlineAttributes = [
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

    public function __construct()
    {
        $this->addBeforeRender(function () {
            $isOptionList = array_is_list((array) $this->get('options', []));
            $this->set('isOptionList', $isOptionList);
        });
    }

    /**
     * @param string|Model $model
     * @param string $name
     * @param string|null $key
     * @return Select
     */
    public function fromModel(Model|string $model, string $name, ?string $key = null): self
    {
        /* @var $model Model */
        $model = is_object($model) ? $model : new $model;
        $key = $key ?? $model->getModel()->getKeyName();

        return $this->setFromEloquent($model, $name, $key);
    }

    /**
     * @param string      $enum
     * @param string|null $displayName
     *
     * @throws ReflectionException
     *
     * @return self
     */
    public function fromEnum(string $enum, ?string $displayName = null): self
    {
        $reflection = new ReflectionEnum($enum);
        $options = [];
        foreach ($enum::cases() as $item) {
            $key = $reflection->isBacked() ? $item->value : $item->name;
            $options[$key] = is_null($displayName) ? __($item->name) : $item->$displayName();
        }
        $this->set('options', $options);

        return $this->addBeforeRender(function () use ($reflection, $enum) {
            $value = [];
            collect($this->get('value'))->each(static function ($item) use (&$value, $reflection, $enum) {
                if ($item instanceof $enum) {
                    /** @var UnitEnum $item */
                    $value[] = $reflection->isBacked() ? $item->value : $item->name;
                } else {
                    $value[] = $item;
                }
            });
            $this->set('value', $value);
        });
    }

    /**
     * @param Model|Builder|Collection $model
     * @param string $name
     * @param string $key
     * @return Select
     */
    private function setFromEloquent(Model|Builder|Collection $model, string $name, string $key): self
    {
        $options = $model->pluck($name, $key);

        $this->set('options', $options);

        return $this->addBeforeRender(function () use ($name) {
            $value = [];

            collect($this->get('value'))->each(static function ($item) use (&$value, $name) {
                if (is_object($item)) {
                    $value[$item->id] = $item->$name;
                } else {
                    $value[] = $item;
                }
            });

            $this->set('value', $value);
        });
    }

    public function fromQuery(Builder $builder, string $name, ?string $key = null): self
    {
        $key = $key ?? $builder->getModel()->getKeyName();

        return $this->setFromEloquent($builder->get(), $name, $key);
    }

    public function empty(string $name = '', string $key = ''): self
    {
        return $this->addBeforeRender(function () use ($name, $key) {
            $options = $this->get('options', []);

            if (! is_array($options)) {
                $options = $options->toArray();
            }

            $value = [$key => $name] + $options;

            $this->set('options', $value);
            $this->set('allowEmpty', '1');
        });
    }

    /**
     * @return self
     */
    public function taggable(): self
    {
        return $this->set('tags');
    }
}
