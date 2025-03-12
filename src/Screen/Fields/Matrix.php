<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Matrix.
 *
 * @method static columns(array $columns)
 * @method static keyValue(bool $keyValue)
 * @method static title(string $value = null)
 * @method static help(string $value = null)
 * @method static sizes(array $sizes)
 */
class Matrix extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.matrix';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'index'             => 0,
        'removableRows'     => true,
        'idPrefix'          => null,
        'maxRows'           => 0,
        'keyValue'          => false,
        'fields'            => [],
        'addRowLabel'       => 'Add row',
        'columns'           => [
            'key',
            'value',
        ],
        'sizes'             => false,
    ];

    /**
     * Matrix constructor.
     */
    public function __construct()
    {
        $this
            ->addBeforeRender(function () {
                if ($this->get('value') === null) {
                    $this->set('value', []);
                }

                $value = collect($this->get('value'))
                    ->sortKeys()
                    ->toArray();

                $this->set('value', $value);
                $this->set('index',
                    empty($value) ? 0 : array_key_last($value)
                );
            })
            ->addBeforeRender(function () {
                $fields = $this->get('fields');

                foreach ($this->get('columns') as $key => $column) {
                    if (! isset($fields[$key])) {
                        $fields[$key] = TextArea::make();
                    }

                    if (! isset($fields[$column])) {
                        $fields[$column] = TextArea::make();
                    }
                }

                $this->set('fields', $fields);
            })
            ->addBeforeRender(function () {
                $idPrefix = $this->getIdPrefix();

                $this->set('idPrefix', $idPrefix);
            });
    }

    /**
     * @param int $count
     *
     * @return static
     */
    public function maxRows(int $count): static
    {
        return $this->set('maxRows', $count);
    }

    /**
     * @param bool $value
     *
     * @return static
     */
    public function removableRows(bool $value = true): static
    {
        return $this->set('removableRows', $value);
    }

    /**
     * @param Field[] $fields
     *
     * @return static
     */
    public function fields(array $fields = []): static
    {
        return $this->set('fields', $fields);
    }

    /**
     * @param string $label
     *
     * @return static
     */
    public function addRowLabel(string $label): static
    {
        return $this->set('addRowLabel', $label);
    }

    protected function getIdPrefix(): string
    {
        $idPrefix = $this->get('idPrefix');

        if ($idPrefix !== null) {
            return (string) $idPrefix;
        }

        $slug = str_replace('.', '-', $this->getOldName());

        return "matrix-field-$slug";
    }
}
