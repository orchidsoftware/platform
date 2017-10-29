<?php

namespace Orchid\Platform\Screen;

use Orchid\Platform\Core\Models\Post;

abstract class Screen
{

    /**
     * Display header name
     *
     * @var string
     */
    public $name;

    /**
     * Display header description
     *
     * @var string
     */
    public $description;

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [];
    }

    /**
     * @return array
     */
    public function build() : array
    {
        //TODO : Вмето Post должег быть какой то класс обёртка
        $post = new Post($this->query());

        foreach ($this->layout() as $layout) {
            $build[] = (new $layout)->build($post);
        }

        return $build ?? [];
    }

    /**
     * Query data
     *
     * @return array
     */
    public function query() : array
    {
        return [];
    }

    /**
     * Views
     *
     * @return array
     */
    public function layout() : array
    {
        return [];
    }

    /**
     * @param array ...$arg
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function handle(...$arg)
    {
        if (!empty($arg) && request()->method() === 'POST') {
            $method = array_shift($arg);

            return $this->$method(request());
        } elseif (!empty($arg) && request()->method() !== 'POST') {
            return abort(404);
        }

        return view('dashboard::container.layouts.base', [
            'name'        => $this->name,
            'description' => $this->description,
            'screen'      => $this,
        ]);
    }
}
