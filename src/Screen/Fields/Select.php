<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Select.
 *
 * @method self accesskey($value = true)
 * @method self autofocus($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self name(string $value = null)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self tabindex($value = true)
 * @method self help(string $value = null)
 * @method self popover(string $value = null)
 * @method self options($value = null)
 */
class Select extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.select';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'   => 'form-control',
        'options' => [],
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'multiple',
        'name',
        'required',
        'size',
        'tabindex',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }

    /**
     * @return self
     */
    public function multiple(): self
    {
        $this->attributes['multiple'] = 'multiple';

        return $this;
    }

    /**
     * @param string|Model $model
     * @param string       $name
     * @param string|null  $key
     *
     * @return self
     */
    public function fromModel($model, string $name, string $key = null): self
    {
        /* @var $model Model */
        $model = is_object($model) ? $model : new $model();
        $key = $key ?? $model->getModel()->getKeyName();

        return $this->setFromEloquent($model, $name, $key);
    }

    /**
     * @param Builder|Model $model
     * @param string        $name
     * @param string        $key
     *
     * @return self
     */
    private function setFromEloquent($model, string $name, string $key)
    {
        $options = $model->pluck($name, $key);

        $this->set('options', $options);

        $this->addBeforeRender(function () {
            $value = [];

            collect($this->get('value'))->each(function ($item) use (&$value) {
                if (is_object($item)) {
                    $value[$item->id] = $item->name;
                } else {
                    $value[] = $item;
                }
            });

            $this->set('value', $value);
        });

        return $this;
    }

    /**
     * @param Builder     $builder
     * @param string      $name
     * @param string|null $key
     *
     * @return self
     */
    public function fromQuery(Builder $builder, string $name, string $key = null): self
    {
        $key = $key ?? $builder->getModel()->getKeyName();

        return $this->setFromEloquent($builder, $name, $key);
    }

    /**
     * @param string $name
     * @param string $key
     *
     * @return self
     */
    public function empty(string $name = '', string $key = ''): self
    {
        $this->addBeforeRender(function () use ($name, $key) {
            $options = $this->get('options', []);

            if (! is_array($options)) {
                $options = $options->toArray();
            }

            $value = array_merge(
                [$key => $name],
                $options
            );

            $this->set('options', $value);
        });

        return $this;
    }
}
