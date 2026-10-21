<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use InvalidArgumentException;
use Orchid\Screen\Field;

/**
 * @method $this fields(array $value = [])
 * @method $this addRowLabel(string $value = null)
 * @method $this idPrefix(string $value = null)
 * @method $this readonly(bool $value = true)
 * @method $this disabled(bool $value = true)
 */
class Repeater extends Field
{
    /**
     * Blade view used to render the field.
     */
    protected $view = 'orchid::fields.repeater';

    /**
     * Default attributes used to configure the field.
     */
    protected $attributes = [
        'value'           => [],
        'fields'          => [],
        'maxRows'         => null,
        'idPrefix'        => null,
        'addRowLabel'     => 'Add row',
        'cloneableRows'   => false,
        'reorderableRows' => false,
        'removableRows'   => true,
        'readonly'        => false,
        'disabled'        => false,
    ];

    /**
     * Initialize the repeater with the requested number of empty rows.
     */
    public function emptyRows(int $count): static
    {
        if ($count < 0) {
            throw new InvalidArgumentException('Repeater empty row count cannot be negative.');
        }

        return $this->value(array_fill(0, $count, []));
    }

    /**
     * Set the maximum row count, or null for no limit.
     */
    public function maxRows(?int $count): static
    {
        if ($count !== null && $count < 0) {
            throw new InvalidArgumentException('Repeater maximum row count cannot be negative.');
        }

        return $this->set('maxRows', $count);
    }

    /**
     * Enable or disable duplicating repeater rows.
     */
    public function cloneableRows(bool $value = true): static
    {
        return $this->set('cloneableRows', $value);
    }

    /**
     * Enable or disable reordering repeater rows.
     */
    public function reorderableRows(bool $value = true): static
    {
        return $this->set('reorderableRows', $value);
    }

    /**
     * Enable or disable removing repeater rows.
     */
    public function removableRows(bool $value = true): static
    {
        return $this->set('removableRows', $value);
    }

    /**
     * Normalize array values to consecutively indexed repeater rows.
     */
    public function value(mixed $value): static
    {
        return parent::value($value instanceof \Closure ? $value : $this->normalizeRows($value));
    }

    protected function updateFieldValue(): static
    {
        if ($this->get('cloneableRows')) {
            foreach ($this->get('fields') as $field) {
                if ($field instanceof self || $field instanceof KeyValue) {
                    throw new InvalidArgumentException('Repeater rows containing Repeater or KeyValue fields cannot be duplicated.');
                }
            }
        }

        parent::updateFieldValue();

        return $this->value($this->get('value'));
    }

    private function normalizeRows(mixed $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        if (! is_array($value) || count(array_filter($value, 'is_array')) !== count($value)) {
            throw new InvalidArgumentException('Repeater values must be an array of row arrays.');
        }

        return array_values($value);
    }
}
