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
    ];

    /**
     * @var array
     */
    public $layouts = [];


    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $new = new Layouts();
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
        $this->active = $name;

        return call_user_func_array([$this, 'setLayouts'], $arguments);
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
        foreach ($this->layouts as $key => $layouts) {
            foreach ($layouts as $layout) {
                if (is_object($layout)) {
                    $build[$key][] = $layout->build($post);
                } else {
                    $build[$key][] = (new $layout)->build($post);
                }
            }
        }

        return view($this->templates[$this->active], [
            'manyForms' => $build ?? [],
        ])->render();
    }
}
