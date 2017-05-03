<?php

namespace Orchid\Behaviors;

use Orchid\Behaviors\Contract\PostInterface;

abstract class Many implements PostInterface
{
    use Structure;

    /**
     * Show the data to the user
     *
     * @var bool
     */
    public $display = true;

    /**
     * Is it possible to give data on api
     *
     * @var bool
     */
    public $api = false;

    /**
     * Eloquent Eager Loading
     *
     * @var array
     */
    public $with = [];

    /**
     * Registered fields for filling
     *
     * @return mixed
     */
    abstract public function fields();

    /**
     * Raw data and fields to display
     *
     * @return array
     */
    public function generateGrid() : array
    {
        $fields = $this->grid();
        $model = new $this->model();
        $search = request('search');

        if (is_null($search) || empty($search)) {
            $data = $model->where('type', $this->slug)
                ->with($this->with)
                ->orderBy('id', 'Desc')
                ->paginate();
        } else {
            $data = $model->where('content', 'LIKE', '%' . $search . '%')
                ->where('type', $this->slug)
                ->with($this->with)
                ->orderBy('id', 'Desc')
                ->paginate();
        }

        return [
            'data'   => $data,
            'fields' => $fields,
            'type'   => $this,
        ];
    }

    /**
     * Registered fields to display in the table
     *
     * @return mixed
     */
    abstract public function grid();
}
