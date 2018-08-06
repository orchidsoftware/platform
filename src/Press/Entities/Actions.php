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
     * @param \Illuminate\Database\Eloquent\Model $post
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(Model $post) : Model
    {
        return $post;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $post
     */
    public function save(Model $post)
    {
        $post->save();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $post
     *
     * @throws \Exception
     */
    public function delete(Model $post)
    {
        $post->delete();
    }
}
