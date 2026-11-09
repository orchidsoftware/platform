<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Support\Arr;
use Orchid\Screen\Field;

/**
 * @method $this keyLabel(string $value = null)
 * @method $this valueLabel(string $value = null)
 * @method $this keyPlaceholder(string $value = null)
 * @method $this valuePlaceholder(string $value = null)
 * @method $this addRowLabel(string $value = null)
 * @method $this addable(bool $value = true)
 * @method $this deletable(bool $value = true)
 * @method $this editableKeys(bool $value = true)
 * @method $this editableValues(bool $value = true)
 * @method $this readonly(bool $value = true)
 * @method $this disabled(bool $value = true)
 */
class KeyValue extends Field
{
    /**
     * Blade view used to render the field.
     */
    protected $view = 'orchid::fields.keyValue';

    /**
     * Default attributes used to configure the field.
     */
    protected $attributes = [
        'value'            => [],
        'keyLabel'         => 'Key',
        'valueLabel'       => 'Value',
        'keyPlaceholder'   => '',
        'valuePlaceholder' => '',
        'addRowLabel'      => 'Add row',
        'disabled'         => false,
        'readonly'         => false,
        'addableRows'      => true,
        'removableRows'    => true,
        'reorderableRows'  => false,
        'editableKeys'     => true,
        'editableValues'   => true,
    ];

    /**
     * Enable or disable adding key-value rows.
     */
    public function addable(bool $value = true): static
    {
        return $this->set('addableRows', $value);
    }

    /**
     * Enable or disable removing key-value rows.
     */
    public function deletable(bool $value = true): static
    {
        return $this->set('removableRows', $value);
    }

    /**
     * Enable or disable reordering key-value rows.
     */
    public function reorderable(bool $value = true): static
    {
        return $this->set('reorderableRows', $value);
    }

    /**
     * Normalize bound values strictly and flashed request input for display.
     */
    protected function updateFieldValue(): static
    {
        $oldInput = request()->hasSession() ? request()->session()->getOldInput() : [];

        if (Arr::has($oldInput, $this->getOldName())) {
            return $this->set('value', $this->oldInputRows(Arr::get($oldInput, $this->getOldName())));
        }

        parent::updateFieldValue();

        return $this->set('value', $this->valueRows($this->get('value')));
    }

    /**
     * Normalize trusted model values and reject unsupported cells.
     */
    private function valueRows(mixed $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        if (! is_array($value)) {
            throw new \InvalidArgumentException('KeyValue expects an array of rows or an associative array.');
        }

        $rows = [];

        foreach ($value as $key => $item) {
            $row = is_int($key) && is_array($item) && array_key_exists('key', $item)
                ? $this->keyValueRow($item)
                : ['key' => $key, 'value' => $item];

            $rows[] = $this->validateRow($row);
        }

        return $rows;
    }

    /**
     * Preserve rejected form rows while making malformed cells safe to display.
     */
    private function oldInputRows(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_map(function ($item, $key): array {
            $row = is_array($item) ? $this->keyValueRow($item) : ['key' => $key, 'value' => $item];

            return array_map(static fn ($cell) => $cell === null || is_scalar($cell) ? $cell : '', $row);
        }, $value, array_keys($value));
    }

    /**
     * Supply missing cells without replacing an explicitly null value.
     */
    private function keyValueRow(array $item): array
    {
        return ['key' => $item['key'] ?? null, 'value' => array_key_exists('value', $item) ? $item['value'] : ''];
    }

    /**
     * Reject nested data supplied through the model or field configuration.
     */
    private function validateRow(array $row): array
    {
        foreach ($row as $cell) {
            if ($cell !== null && ! is_scalar($cell)) {
                throw new \InvalidArgumentException('KeyValue keys and values must be scalar or null.');
            }
        }

        return $row;
    }

    /**
     * Convert rows with nonempty keys into an associative array.
     */
    public static function rowsToArray(array $rows): array
    {
        return collect($rows)
            ->filter(fn (array $row) => filled($row['key'] ?? null))
            ->mapWithKeys(fn (array $row) => [$row['key'] => $row['value'] ?? null])
            ->all();
    }
}
