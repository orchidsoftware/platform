<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Services\Forms\Form;

class BasePostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Общее';

    /**
     * Display Settings App.
     *
     * @param null $storage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($TEST = null, $test2 = null)
    {
        dd($TEST, $test2);

        return view('dashboard::container.posts.modules.base');
    }

    /**
     * Save Base Role.
     *
     * @param null $storage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist()
    {
    }

    /**
     * @param Role $role
     */
    public function delete()
    {
    }
}
