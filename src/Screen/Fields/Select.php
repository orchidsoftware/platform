<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Support\ChoicePayload;

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
 */
class Select extends Field implements ComplexFieldConcern
{
    use Multipliable;

    /**
     * Default chunk size for lazy loading (options per request).
     */
    public const DEFAULT_LAZY_CHUNK = 10;

    /**
     * View template show.
     *
     * @var string
     */
    protected $view = 'orchid::fields.select';

    /**
     * Default attributes value.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'class'                 => 'form-control',
        'options'               => [],
        'allowEmpty'            => false,
        'allowCreate'           => false,
        'isOptionList'          => false,
        'lazyChunk'             => null,
        'relationModel'         => null,
        'relationName'          => null,
        'relationKey'           => null,
        'relationScope'         => null,
        'relationAppend'        => null,
        'relationSearchColumns' => null,
        'relationHandler'       => false,
        'choices'               => null,
        'isLazy'                => false,
        'selectedValues'        => [],
        'allowEmptyValue'       => 'false',
        'allowCreateValue'      => 'false',
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

    /**
     * Create a new select field instance.
     */
    public function __construct()
    {
        $this->addBeforeRender(fn () => $this->prepareForRender());
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
        $instance = $model instanceof Model ? $model : new $model;
        $modelClass = $instance::class;
        $key ??= $instance->getKeyName();

        $this->setRelationParams($modelClass, $name, $key);

        if ($this->isLazy()) {
            return $this;
        }

        return $this->setFromEloquent($instance, $name, $key);
    }

    /**
     * Apply a scope when loading lazy options (e.g. filter by tenant).
     */
    public function applyScope(string $scope, mixed ...$parameters): static
    {
        return $this->set('relationScope', [
            'name'       => lcfirst($scope),
            'parameters' => $parameters,
        ]);
    }

    /**
     * Columns to search when loading lazy options.
     */
    public function searchColumns(string|array ...$columns): static
    {
        return $this->set('relationSearchColumns', Arr::flatten($columns));
    }

    /**
     * Use another attribute for the option label in lazy mode.
     */
    public function displayAppend(string $append): static
    {
        return $this->set('relationAppend', $append);
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
     * Allow creating options that are not present in the loaded list.
     */
    public function allowCreate(bool $value = true): static
    {
        return $this->set('allowCreate', $value);
    }

    /**
     * Allow creating options that are not present in the loaded list.
     *
     * @deprecated Use allowCreate() instead.
     */
    public function allowAdd(bool $value = true): static
    {
        return $this->allowCreate($value);
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

            $this
                ->set('value', $value)
                ->refreshSelectedValues();
        });
    }

    /**
     * Populate options from an Eloquent query.
     */
    public function fromQuery(Builder $builder, string $name, ?string $key = null): static
    {
        $key ??= $builder->getModel()->getKeyName();

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

            $options = is_array($options)
                ? $options
                : $options->toArray();

            $this
                ->set('options', [$key => $name] + $options)
                ->set('allowEmpty', true)
                ->set('allowEmptyValue', 'true');
        });
    }

    /**
     * Allow selecting multiple options.
     *
     * @deprecated
     */
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
     * Prepare the values consumed by the select Blade view.
     */
    protected function prepareForRender(): void
    {
        $this
            ->set('isLazy', $this->hasLazyChoices())
            ->set('allowEmptyValue', var_export($this->get('allowEmpty'), true))
            ->set('allowCreateValue', var_export($this->get('allowCreate'), true));

        $this->refreshSelectedValues();

        if ($this->get('isLazy')) {
            if (! $this->get('relationHandler')) {
                $this->set('value', $this->choicePayload()->selectedOptions($this->get('value')));
            }

            $this->refreshChoices();

            return;
        }

        $this->set('isOptionList', array_is_list((array) $this->get('options', [])));
    }

    /**
     * Determine whether the field has enough information for lazy choices.
     */
    protected function hasLazyChoices(): bool
    {
        return $this->isLazy() && ! empty($this->get('relationModel'));
    }

    /**
     * Store relation params so lazy() works whether called before or after fromModel().
     */
    protected function setRelationParams(string $modelClass, string $name, string $key): static
    {
        return $this
            ->set('relationModel', $modelClass)
            ->set('relationName', $name)
            ->set('relationKey', $key);
    }

    /**
     * Return the relation append attribute name, or null.
     */
    protected function resolveRelationAppend(): ?string
    {
        $append = $this->get('relationAppend');

        return is_string($append) && $append !== '' ? $append : null;
    }

    /**
     * Build the encrypted choices payload exposed to JavaScript.
     *
     * Relation settings are kept as plain PHP values while the field is being
     * configured, then converted into a single encrypted payload before render.
     * That keeps the browser contract compact without encrypting every
     * intermediate field attribute separately.
     */
    protected function refreshChoices(): void
    {
        $this->set('choices', (string) $this->choicePayload());
    }

    /**
     * Build the choices payload from the configured relation settings.
     */
    protected function choicePayload(): ChoicePayload
    {
        $model = $this->get('relationModel');
        $name = $this->get('relationName');
        $key = $this->get('relationKey');

        if (! is_string($model) || ! is_string($name) || ! is_string($key)) {
            throw new \UnexpectedValueException('Choice payload attributes must not be empty.');
        }

        return new ChoicePayload(
            model: $model,
            name: $name,
            key: $key,
            chunk: (int) $this->get('lazyChunk', self::DEFAULT_LAZY_CHUNK),
            scope: $this->get('relationScope'),
            append: $this->resolveRelationAppend(),
            searchColumns: $this->get('relationSearchColumns', []),
        );
    }

    /**
     * Populate options from resolved Eloquent models.
     *
     * @param Model|Collection $source
     */
    private function setFromEloquent(Model|Collection $source, string $name, string $key): static
    {
        $this->set('options', $source->pluck($name, $key));

        return $this->addBeforeRender(function () use ($key): void {
            if ($this->get('isLazy')) {
                return;
            }

            $this
                ->set('value', $this->normalizeSelectedValues($this->get('value'), $key))
                ->refreshSelectedValues();
        });
    }

    /**
     * Refresh the normalized selected values exposed to the Blade view.
     */
    private function refreshSelectedValues(): static
    {
        return $this->set('selectedValues', $this->get('isLazy') ? [] : $this->selectedValues());
    }

    /**
     * Values selected in eager mode, normalized for strict Blade checks.
     *
     * @return array<int, string>
     */
    private function selectedValues(): array
    {
        $value = $this->get('value', []);
        $items = is_array($value) && ! array_is_list($value)
            ? array_keys($value)
            : Arr::wrap($value);

        return collect($items)
            ->map(fn ($item): string => (string) $this->enumValue($item))
            ->all();
    }

    /**
     * Convert selected model/array/scalar values into the option keys expected by the select view.
     *
     * @return array<int, mixed>
     */
    private function normalizeSelectedValues(mixed $value, string $key): array
    {
        $items = $value instanceof Collection ? $value : collect(Arr::wrap($value));

        return $items
            ->map(fn ($item) => $this->normalizeSelectedValue($item, $key))
            ->filter(static fn ($item): bool => $item !== null)
            ->values()
            ->all();
    }

    /**
     * Normalize one selected model, array, scalar, or enum value.
     */
    private function normalizeSelectedValue(mixed $item, string $key): mixed
    {
        $value = is_object($item) || is_array($item)
            ? data_get($item, $key)
            : $item;

        return $this->enumValue($value);
    }

    /**
     * Convert enum values into their scalar representation.
     */
    private function enumValue(mixed $value): mixed
    {
        return $value instanceof \BackedEnum
            ? $value->value
            : ($value instanceof \UnitEnum ? $value->name : $value);
    }
}
