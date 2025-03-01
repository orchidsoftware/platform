<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;
use Orchid\Support\QuerySerializer;

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
 * @method Select taggable($value = true)
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
        'chunk'         => 10,
        'lazy'          => false,
        'searchColumns' => null,
        'lazyName'      => null,
        'lazyDisplay'   => null,
        'lazyKey'       => null,
        'lazyQuery'     => null,
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

    public function fromModel(string|Model|Builder $model, string $name, ?string $key = null): static
    {
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
            ->when($this->get('lazy'), fn($query) => $query->take($this->get('chunk')));

        $name = 'name';

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

        if (is_string($append)) {
            $append = Crypt::decryptString($append);
        }

        if ($model instanceof Builder) {
            $model = $model->getModel();
        }

        if (!empty($append) && $model->hasAttribute($append)) {
            return $append;
        }

        return $name;
    }

    public function displayAppend(string $append): static
    {
        $this->set('displayAppend', Crypt::encryptString($append));

        return $this;
    }

    public function chunk(int $chunk = 10): static
    {
        $this->set('chunk', $chunk);
        $this->set('lazy');

        return $this;
    }

    public function searchColumns(...$columns): static
    {
        $columns = Arr::wrap($columns);

        $this->set('searchColumns', Crypt::encrypt($columns));

        return $this;
    }

    private function prepareLazyQuery(string $name, string $key, Builder $query, string $display = null): void
    {
        $this->set('lazyName', $name);
        $this->set('lazyKey', $key);
        $this->set('lazyQuery', QuerySerializer::serialize($query));
        $this->set('lazyDisplay', $display);
    }

}
