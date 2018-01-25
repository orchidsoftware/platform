<?php

namespace Orchid\Platform\Screen;

class Layouts
{
    /**
     * @var null
     */
    public $active = null;

    /**
     * @var array
     */
    public $templates = [
        'tabs'    => 'dashboard::container.layouts.tabs',
        'columns' => 'dashboard::container.layouts.columns',
        'modals'  => 'dashboard::container.layouts.modals',
        'div'     => 'dashboard::container.layouts.div',
    ];

    /**
     * @var array
     */
    public $layouts = [];

    /**
     * @var array
     */
    public $compose = [];

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $new = new self();
        $new->active = $name;

        return call_user_func_array([$new, 'setLayouts'], $arguments);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (is_null($name)) {
            $this->active = $name;

            return call_user_func_array([$this, 'setLayouts'], $arguments);
        }

        $this->compose[$name] = array_shift($arguments);

        return $this;
    }

    /**
     * @param $property
     *
     * @return mixed
     */
    protected function setLayouts($property)
    {
        $this->layouts = $property;

        return $this;
    }

    /**
     * @param $post
     *
     * @return array
     * @throws \Throwable
     */
    public function build($post)
    {

        //dd($this->layouts);

        foreach ($this->layouts as $key => $layouts) {
            foreach ($layouts as $layout) {
                $build[$key][] = is_object($layout) ? $layout->build($post) : (new $layout)->build($post);
            }
        }

        return view($this->templates[$this->active], [
            'manyForms' => $build ?? [],
            'compose'   => $this->compose,
        ])->render();
    }
}
