<?php

namespace Orchid\Platform\Screen;

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
     * @var array
     */
    private $arguments = [];

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
        $query = call_user_func_array([$this, 'query'], $this->arguments);

        foreach ($this->layout() as $layout) {
            $post = new Repository($query[$layout]);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function handle(...$arg)
    {
        $this->arguments = $arg;


        // first
        $method = array_shift($arg);
        if (method_exists($this, $method)) {
            array_unshift($this->arguments, request());
            return call_user_func_array([$this, $method], $this->arguments);
        }

        //last
        $method = array_pop($arg);
        if (method_exists($this, $method)) {
            array_unshift($this->arguments, request());
            return call_user_func_array([$this, $method], $this->arguments);
        }


        return $this->view();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('dashboard::container.layouts.base', [
            'name'        => $this->name,
            'description' => $this->description,
            'screen'      => $this,
        ]);
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        foreach ($this->arguments as $argument) {
            if (method_exists($this, $argument)) {
                $arguments[] =  $argument;
            }
        }

        return $arguments ?? [];
    }
}
