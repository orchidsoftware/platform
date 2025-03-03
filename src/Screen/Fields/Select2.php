<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;
use Orchid\Support\Select2LazyQuery;

/**
 * Class Select2.
 *
 * @method Select2 accesskey($value = true)
 * @method Select2 autofocus($value = true)
 * @method Select2 disabled($value = true)
 * @method Select2 form($value = true)
 * @method Select2 name(string $value = null)
 * @method Select2 required(bool $value = true)
 * @method Select2 size($value = true)
 * @method Select2 tabindex($value = true)
 * @method Select2 help(string $value = null)
 * @method Select2 popover(string $value = null)
 * @method Select2 options($value = null)
 * @method Select2 title(string $value = null)
 * @method Select2 maximumSelectionLength(int $value = 0)
 * @method Select2 allowAdd($value = true)
 * @method Select2 taggable($value = true)
 * @method Select2 displayAppend(string $value)
 * @method Select2 allowEmpty(bool $value = true)
 */
class Select2 extends Field implements ComplexFieldConcern
{
    use Multipliable;

    protected string $view = 'platform::fields.select2';

    /**
     * Default attributes value.
     */
    protected array $attributes = [
        'class'         => 'form-control',
        'options'       => [],
        'allowEmpty'    => '',
        'allowAdd'      => false,
        'isOptionList'  => false,
        'chunk'         => null,
        'searchColumns' => null,
        'display'       => null,
        'key'           => null,
        'query'         => null,
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

    public function fromModel(
        string|Model|Builder $model,
        string $name, ?string
        $key = null,
        ?int $chunk = null
    ): static
    {
        $this->set('chunk', $chunk);

        $model = is_object($model) ? $model : new $model;
        $key = $key ?? $model->getModel()->getKeyName();

        return $this->setFromEloquent($model, $name, $key);
    }

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
     * @param string $name
     * @param string $key
     * @return Select2
     */
    private function setFromEloquent(Builder|Model $model, string $name, string $key): static
    {
        $display = $this->getDisplayAppend($model, $name);

        $query = $model
            ->when($this->get('chunk'), fn($query) => $query->take($this->get('chunk')));

        $this->prepareLazyQuery($name, $key, $query, $display);

        $options = $query
            ->get()
            ->mapWithKeys(function ($model) use ($display, $key) {
                return [$model->$key => $model->$display];
            });

        $this->set('options', $options);

        return $this->addBeforeRender(function () use ($display, $key) {
            $value = [];
            collect($this->get('value'))->each(static function ($item) use (&$value, $display, $key) {
                if (is_object($item)) {
                    $value[$item->$key] = $item->$display;
                } else {
                    $value[] = $item;
                }
            });

            $this->set('options', $this->get('options')->union(collect($value)));
            $this->set('value', $value);
        });
    }

    private function getDisplayAppend(Model|Builder $model, string $name)
    {
        $append = $this->get('displayAppend');

        if ($model instanceof Builder) {
            $model = $model->getModel();
        }

        if (!empty($append) && $model->hasAttribute($append)) {
            return $append;
        }

        return $name;
    }

    /**
     * Set the maximum number of items that may be selected.
     *
     * @return $this
     */
    public function max(int $number): static
    {
        $this->set('data-maximum-selection-length', (string) $number);

        return $this;
    }

    public function searchColumns(...$columns): static
    {
        $columns = Arr::wrap($columns);

        $this->set('searchColumns', $columns);

        return $this;
    }

    private function prepareLazyQuery(string $name, string $key, Builder $query, string $display = null): void
    {
        $queryClone = clone $query;
        $this->set('key', $key);
        $this->set('query', Select2LazyQuery::prepare($queryClone, $name, $this->get('searchColumns')));
        $this->set('display', $display);
    }

}
