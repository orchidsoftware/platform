<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Fields\Select;
use Stringable;
use UnexpectedValueException;

final readonly class ChoicePayload implements Stringable
{
    /**
     * Create a new choices payload instance.
     *
     * @param class-string<Model>                                       $model
     * @param array{name?: string, parameters?: array<int, mixed>}|null $scope
     * @param array<int, string>                                        $searchColumns
     */
    public function __construct(
        public string $model,
        public string $name,
        public string $key,
        public int $chunk = Select::DEFAULT_LAZY_CHUNK,
        public ?array $scope = null,
        public ?string $append = null,
        public array $searchColumns = [],
        public string $search = '',
    ) {}

    /**
     * Encrypt the payload for transport through the browser.
     */
    public function __toString(): string
    {
        return Crypt::encrypt($this->toArray());
    }

    /**
     * Create a payload instance from an encrypted browser value.
     */
    public static function fromEncrypted(?string $payload): self
    {
        if ($payload === null || $payload === '') {
            throw new UnexpectedValueException('Choice payload is empty.');
        }

        return self::fromArray(Crypt::decrypt($payload));
    }

    /**
     * Create a payload instance from a plain array.
     *
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            model: (string) ($payload['model'] ?? ''),
            name: (string) ($payload['name'] ?? ''),
            key: (string) ($payload['key'] ?? ''),
            chunk: (int) ($payload['chunk'] ?? Select::DEFAULT_LAZY_CHUNK),
            scope: self::normalizeScope($payload['scope'] ?? null),
            append: filled($payload['append'] ?? null) ? (string) $payload['append'] : null,
            searchColumns: self::normalizeColumns($payload['searchColumns'] ?? []),
            search: (string) ($payload['search'] ?? ''),
        );
    }

    /**
     * Convert the payload into its encrypted array representation.
     *
     * @return array{model: string, name: string, key: string, chunk: int, scope: array{name: string, parameters: array<int, mixed>}|null, append: string|null, searchColumns: array<int, string>}
     */
    public function toArray(): array
    {
        return [
            'model'         => $this->model,
            'name'          => $this->name,
            'key'           => $this->key,
            'chunk'         => $this->chunk,
            'scope'         => $this->scope,
            'append'        => $this->append,
            'searchColumns' => $this->searchColumns,
        ];
    }

    /**
     * Create a copy of the payload with a new search term.
     */
    public function withSearch(string $search): self
    {
        return new self(
            model: $this->model,
            name: $this->name,
            key: $this->key,
            chunk: $this->chunk,
            scope: $this->scope,
            append: $this->append,
            searchColumns: $this->searchColumns,
            search: $search,
        );
    }

    /**
     * Create a copy of the payload with a new result limit.
     */
    public function withChunk(int $chunk): self
    {
        return new self(
            model: $this->model,
            name: $this->name,
            key: $this->key,
            chunk: $chunk,
            scope: $this->scope,
            append: $this->append,
            searchColumns: $this->searchColumns,
            search: $this->search,
        );
    }

    /**
     * Ensure the payload can be safely used to resolve choices.
     */
    public function assertValid(): self
    {
        if (! class_exists($this->model) || ! is_subclass_of($this->model, Model::class)) {
            throw new UnexpectedValueException('Choice payload model must be an Eloquent model.');
        }

        if ($this->name === '' || $this->key === '') {
            throw new UnexpectedValueException('Choice payload attributes must not be empty.');
        }

        return $this;
    }

    /**
     * Create the model instance represented by the payload.
     */
    public function modelInstance(): Model
    {
        $this->assertValid();

        return new $this->model;
    }

    /**
     * Build the query or scoped source used to resolve choices.
     *
     * @return Builder|Collection|array<int, mixed>
     */
    public function query(): Builder|Collection|array
    {
        $model = $this->modelInstance();

        if ($this->scope === null) {
            return $model->newQuery();
        }

        return $model->newQuery()->{$this->scope['name']}(...$this->scope['parameters']);
    }

    /**
     * Get the attribute used as the visible label.
     */
    public function labelAttribute(): string
    {
        return $this->append ?: $this->name;
    }

    /**
     * Get the columns that should be searched for this payload.
     *
     * @return array<int, string>
     */
    public function searchableColumns(): array
    {
        return array_values(array_unique([
            $this->name,
            ...$this->searchColumns,
        ]));
    }

    /**
     * Convert a model or array item into a browser choice option.
     *
     * @param object|array<string, mixed> $item
     *
     * @return array{value: mixed, label: mixed}
     */
    public function optionFrom(object|array $item): array
    {
        $value = data_get($item, $this->key);
        $label = data_get($item, $this->labelAttribute())
            ?? data_get($item, $this->name)
            ?? $value;

        return [
            'value' => $this->enumValue($value),
            'label' => $this->enumValue($label),
        ];
    }

    /**
     * Resolve current selected values into the initial option shape TomSelect expects.
     *
     * @return array<int, array{id: mixed, text: mixed}>
     */
    public function selectedOptions(mixed $value): array
    {
        $items = is_iterable($value) ? $value : Arr::wrap($value);

        if (! $this->isObjectArray($items)) {
            $items = $this->selectedItems($items);
        }

        return collect($items)
            ->map(fn ($item): array => [
                'id'   => $this->enumValue(data_get($item, $this->key)),
                'text' => $this->enumValue(data_get($item, $this->labelAttribute())),
            ])
            ->toArray();
    }

    /**
     * Normalize the configured searchable columns.
     *
     * @return array<int, string>
     */
    private static function normalizeColumns(mixed $columns): array
    {
        return collect(Arr::wrap($columns))
            ->flatten()
            ->filter(fn ($column): bool => is_string($column) && $column !== '')
            ->values()
            ->all();
    }

    /**
     * Normalize the configured scope definition.
     *
     * @return array{name: string, parameters: array<int, mixed>}|null
     */
    private static function normalizeScope(mixed $scope): ?array
    {
        if (! is_array($scope) || blank($scope['name'] ?? null)) {
            return null;
        }

        return [
            'name'       => (string) $scope['name'],
            'parameters' => array_values(Arr::wrap($scope['parameters'] ?? [])),
        ];
    }

    /**
     * Resolve selected model records for scalar selected keys.
     *
     * @param iterable<int, mixed> $keys
     */
    private function selectedItems(iterable $keys): iterable
    {
        $query = $this->query();

        return $query instanceof Builder
            ? $query->whereIn($this->key, $keys)->get()
            : collect($query)->whereIn($this->key, $keys)->values();
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

    /**
     * Determine whether the given iterable already contains resolved items.
     */
    private function isObjectArray(iterable $items): bool
    {
        foreach ($items as $item) {
            if (! is_object($item) && ! is_array($item)) {
                return false;
            }
        }

        return true;
    }
}
