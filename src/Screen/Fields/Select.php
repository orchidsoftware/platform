<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;
use Orchid\Support\Assert;

/**
 * Unified select field.
 *
 * Options can be loaded:
 * - Eagerly: fromModel(), fromQuery(), fromEnum(), or options()
 * - Lazily via HTTP: fromModel()->lazy($chunk) — loads in chunks when the user focuses or searches
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this name(string $value = null)
 * @method $this required(bool $value = true)
 * @method $this size($value = true)
 * @method $this tabindex($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this options($value = null)
 * @method $this title(string $value = null)
 * @method $this maximumSelectionLength(int $value = 0)
 * @method $this allowAdd($value = true)
 */
class Select extends Field implements ComplexFieldConcern
{
    use Multipliable;

    /**
     * Default chunk size for lazy loading (options per request).
     */
    public const DEFAULT_LAZY_CHUNK = 10;

    protected $view = 'orchid::fields.select';

    /**
     * Default attributes value.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'class'                 => 'form-control',
        'options'               => [],
        'allowEmpty'            => '',
        'allowAdd'              => false,
        'isOptionList'          => false,
        'lazyChunk'             => null,
        'relationModel'         => null,
        'relationName'          => null,
        'relationKey'           => null,
        'relationScope'         => null,
        'relationAppend'        => null,
        'relationSearchColumns' => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array<int, string>
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
        'data-maximum-selection-length',
    ];

    public function __construct()
    {
        $this->addBeforeRender(function (): void {
            if ($this->isLazy()) {
                return;
            }
            $options = $this->get('options', []);
            $this->set('isOptionList', array_is_list((array) $options));
        });
    }

    /**
     * Load options in chunks via HTTP. Only applies when used with fromModel().
     * Ignored with fromQuery(), fromEnum(), or options() — those load eagerly.
     */
    public function lazy(int $chunk = self::DEFAULT_LAZY_CHUNK): static
    {
        return $this->set('lazyChunk', $chunk);
    }

    /**
     * Populate options from an Eloquent model (or class name).
     * Use with lazy() to load options via HTTP in chunks.
     */
    public function fromModel(string|Model $model, string $name, ?string $key = null): static
    {
        $modelClass = $model instanceof Model ? get_class($model) : $model;
        $instance = $model instanceof Model ? $model : new $model;
        $key = $key ?? $instance->getModel()->getKeyName();

        $this->setRelationParams($modelClass, $name, $key);

        if ($this->isLazy()) {
            $this->addBeforeRender(fn () => $this->resolveLazyDisplayValue($modelClass, $name, $key));

            return $this;
        }

        return $this->setFromEloquent($instance, $name, $key);
    }

    /**
     * Apply a scope when loading lazy options (e.g. filter by tenant).
     */
    public function applyScope(string $scope, mixed ...$parameters): static
    {
        $this->set('relationScope', Crypt::encrypt([
            'name'       => lcfirst($scope),
            'parameters' => $parameters,
        ]));

        return $this;
    }

    /**
     * Columns to search when loading lazy options.
     */
    public function searchColumns(string|array ...$columns): static
    {
        $this->set('relationSearchColumns', Crypt::encrypt(Arr::flatten($columns)));

        return $this;
    }

    /**
     * Use another attribute for the option label in lazy mode.
     */
    public function displayAppend(string $append): static
    {
        $this->set('relationAppend', Crypt::encryptString($append));

        return $this;
    }

    /**
     * Maximum number of items that can be selected.
     */
    public function max(int $number): static
    {
        return $this->set('data-maximum-selection-length', (string) $number);
    }

    /**
     * Allow no selection (empty value).
     */
    public function allowEmpty(bool $value = true): static
    {
        return $this->set('allowEmpty', $value);
    }

    /**
     * Populate options from a PHP enum.
     */
    public function fromEnum(string $enum, ?string $displayName = null): static
    {
        $reflection = new \ReflectionEnum($enum);
        $options = [];
        foreach ($enum::cases() as $case) {
            $optionKey = $reflection->isBacked() ? $case->value : $case->name;
            $options[$optionKey] = $displayName === null ? __($case->name) : $case->$displayName();
        }
        $this->set('options', $options);

        return $this->addBeforeRender(function () use ($reflection, $enum): void {
            $value = collect($this->get('value'))->map(function ($item) use ($reflection, $enum) {
                return $item instanceof $enum
                    ? ($reflection->isBacked() ? $item->value : $item->name)
                    : $item;
            })->all();
            $this->set('value', $value);
        });
    }

    /**
     * Populate options from an Eloquent query.
     */
    public function fromQuery(Builder $builder, string $name, ?string $key = null): static
    {
        $key = $key ?? $builder->getModel()->getKeyName();

        return $this->setFromEloquent($builder->get(), $name, $key);
    }

    /**
     * Prepend an empty option to the list.
     *
     * @param string $name Label for the empty option
     * @param string $key  Value for the empty option
     */
    public function empty(string $name = '', string $key = ''): static
    {
        return $this->addBeforeRender(function () use ($name, $key): void {
            $options = $this->get('options', []);
            $options = is_array($options) ? $options : $options->toArray();
            $this->set('options', [$key => $name] + $options);
            $this->set('allowEmpty', '1');
        });
    }

    public function taggable(): static
    {
        return $this->set('tags', true);
    }

    /**
     * Whether the field is in lazy (HTTP) mode.
     */
    protected function isLazy(): bool
    {
        return $this->get('lazyChunk') !== null;
    }

    /**
     * Store encrypted relation params so lazy() works whether called before or after fromModel().
     */
    protected function setRelationParams(string $modelClass, string $name, string $key): static
    {
        return $this
            ->set('relationModel', Crypt::encryptString($modelClass))
            ->set('relationName', Crypt::encryptString($name))
            ->set('relationKey', Crypt::encryptString($key));
    }

    /**
     * Normalize current value to [{id, text}] for the lazy select view.
     */
    protected function resolveLazyDisplayValue(string $modelClass, string $name, string $key): void
    {
        $labelAttribute = $this->resolveRelationAppend() ?? $name;
        $value = $this->get('value');
        $value = is_iterable($value) ? $value : Arr::wrap($value);

        if (! Assert::isObjectArray($value)) {
            $value = $modelClass::whereIn($key, $value)->get();
        }

        $normalized = collect($value)->map(function ($item) use ($key, $labelAttribute) {
            $id = $item->$key;
            $text = $item->$labelAttribute;

            return [
                'id'   => $id instanceof \UnitEnum ? $id->value : $id,
                'text' => $text instanceof \UnitEnum ? $text->value : $text,
            ];
        })->toArray();

        $this->set('value', $normalized);
    }

    /**
     * Decrypt and return the relation append attribute name, or null.
     */
    protected function resolveRelationAppend(): ?string
    {
        $append = $this->get('relationAppend');
        if ($append === null || $append === '') {
            return null;
        }

        return is_string($append) ? Crypt::decryptString($append) : null;
    }

    /**
     * @param Model|Collection $source
     */
    private function setFromEloquent(Model|Collection $source, string $name, string $key): static
    {
        $options = $source->pluck($name, $key);
        $this->set('options', $options);

        return $this->addBeforeRender(function () use ($name, $key): void {
            $value = [];
            foreach (collect($this->get('value')) as $item) {
                if (is_object($item)) {
                    $value[$item->$key] = $item->$name;
                } else {
                    $value[] = $item;
                }
            }
            $this->set('value', $value);
        });
    }
}
