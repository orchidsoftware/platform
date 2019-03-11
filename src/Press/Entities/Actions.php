<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\Paginator;

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

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->slug;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->slug;
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return $value;
    }
}
