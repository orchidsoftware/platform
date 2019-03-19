<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Layouts;

use Orchid\Screen\Layouts\Table;

class EntitiesLayout extends Table
{
    /**
     * @var string
     */
    public $data = 'data';

    /**
     * @var array
     */
    public $fields = [];

    /**
     * EntitiesLayout constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = [])
    {
        $this->fields = $fields;
    }

    /**
     * @param mixed|null $data
     *
     * @return array
     */
    public function fields($data = null): array
    {
        return $this->fields;
    }
}
