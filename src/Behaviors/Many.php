<?php

namespace Orchid\Behaviors;

use Orchid\Behaviors\Contract\ManyInterface;

abstract class Many implements ManyInterface
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
     * HTTP data filters
     *
     * @var array
     */
    public $filters = [];

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
    public function generateGrid(): array
    {
        $fields = $this->grid();
        $model = new $this->model();
        $search = request('search');

        if (is_null($search) || empty($search)) {
            $data = $model->type($this->slug)
                ->filtersApplyDashboard($this->slug)
                ->with($this->with)
                ->orderBy('id', 'Desc')
                ->paginate();
        } else {
            $data = $model->where('content', 'LIKE', '%' . $search . '%')
                ->filtersApplyDashboard($this->slug)
                ->type($this->slug)
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
