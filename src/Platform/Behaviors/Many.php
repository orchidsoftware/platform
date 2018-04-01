<?php

declare(strict_types=1);

namespace Orchid\Platform\Behaviors;

use Orchid\Platform\Core\Models\Post;

abstract class Many
{
    use Structure;

    /**
     * Eloquent Eager Loading.
     *
     * @var array
     */
    public $with = [];

    /**
     * Registered fields for filling.
     *
     * @return mixed
     */
    abstract public function fields() : array;

    /**
     * Registered fields to display in the table.
     *
     * @return array
     */
    abstract public function grid() : array;

    /**
     * Raw data and fields to display.
     *
     * @return array
     */
    public function generateGrid() : array
    {
        $fields = $this->grid();

        $data = Post::type($this->slug)
            ->filters()
            ->with($this->with)
            ->orderBy('id', 'Desc')
            ->paginate();

        return [
            'data'   => $data,
            'fields' => $fields,
            'type'   => $this,
        ];
    }
}
