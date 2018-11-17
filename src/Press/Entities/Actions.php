<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

trait Actions
{
    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get(): Paginator
    {
        return collect();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(Model $model): Model
    {
        return $model;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function save(Model $model)
    {
        $model->save();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @throws \Exception
     */
    public function delete(Model $model)
    {
        $model->delete();
    }
}
