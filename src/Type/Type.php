<?php

namespace Orchid\Type;

abstract class Type implements TypeInterface
{
    use Structure;

    /**
     * @var bool
     */
    public $display = true;

    /**
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
     * @return mixed
     */
    abstract public function fields();

    /**
     * Raw data and fields to display
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
     * @return mixed
     */
    abstract public function grid();
}
