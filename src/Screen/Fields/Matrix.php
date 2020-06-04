<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Matrix.
 *
 * @method Matrix columns(array $columns)
 * @method Matrix keyValue(bool $keyValue)
 * @method Matrix title(string $value = null)
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
        'maxRows'  => 0,
        'keyValue' => false,
        'columns'  => [
            'key',
            'value',
        ],
    ];

    /**
     * Matrix constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            if ($this->get('value') === null) {
                $this->set('value', []);
            }
        });
    }

    /**
     * @param int $count
     *
     * @return Field|Matrix
     */
    public function maxRows(int $count)
    {
        return $this->set('maxRows', $count);
    }
}
