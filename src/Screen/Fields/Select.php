<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

/**
 * Class Select.
 *
* @method static accesskey($value = true)
* @method static autofocus($value = true)
* @method static disabled($value = true)
* @method static form($value = true)
* @method static name(string $value = null)
* @method static required(bool $value = true)
* @method static size($value = true)
* @method static tabindex($value = true)
* @method static help(string $value = null)
* @method static popover(string $value = null)
* @method static options($value = null)
* @method static title(string $value = null)
* @method static maximumSelectionLength(int $value = 0)
* @method static allowAdd($value = true)
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
     */
    public function fromModel($model, string $name, ?string $key = null): static
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
     * @throws \ReflectionException
     *
     * @return static
     */
    public function fromEnum(string $enum, ?string $displayName = null): static
    {
        $reflection = new \ReflectionEnum($enum);
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
                    /** @var \UnitEnum $item */
                    $value[] = $reflection->isBacked() ? $item->value : $item->name;
                } else {
                    $value[] = $item;
                }
            });
            $this->set('value', $value);
        });
    }

    /**
     * @param Builder|Model $model
     */
    private function setFromEloquent($model, string $name, string $key): static
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

    public function fromQuery(Builder $builder, string $name, ?string $key = null): static
    {
        $key = $key ?? $builder->getModel()->getKeyName();

        return $this->setFromEloquent($builder->get(), $name, $key);
    }

    public function empty(string $name = '', string $key = ''): static
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
     * @return static
     */
    public function taggable(): static
    {
        return $this->set('tags', true);
    }
}
