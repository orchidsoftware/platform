<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

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
     * Normalize after repository binding and old input have been applied.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            $value = $this->get('value');

            if ($value === null || $value === '') {
                $value = [];
            }

            if (! is_array($value)) {
                throw new \InvalidArgumentException('KeyValue expects an array of rows or an associative array.');
            }

            $rows = [];

            foreach ($value as $key => $item) {
                $row = is_int($key) && is_array($item) && array_key_exists('key', $item)
                    ? ['key' => $item['key'], 'value' => array_key_exists('value', $item) ? $item['value'] : '']
                    : ['key' => $key, 'value' => $item];

                foreach ($row as $cell) {
                    if ($cell !== null && ! is_scalar($cell)) {
                        throw new \InvalidArgumentException('KeyValue keys and values must be scalar or null.');
                    }
                }

                $rows[] = $row;
            }

            $this->set('value', $rows);
        });
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
