<?php

namespace Orchid\Platform\Screen;

class Link
{
    /**
     * @var
     */
    public $slug;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $method;

    /**
     * @var
     */
    public $url;

    /**
     * @var
     */
    public $icon;

    /**
     * @var
     */
    public $modal;

    /**
     * @var
     */
    public $title;

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $new = new Link();

        return call_user_func_array([$new, 'rewriteProperty'], [$name, $arguments[0]]);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this, 'rewriteProperty'], [$name, $arguments[0]]);
    }

    /**
     * @param null $arguments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build($arguments = null)
    {
        return view('dashboard::partials.screen.link', [
            'slug'      => $this->slug,
            'name'      => $this->name,
            'method'    => $this->method,
            'icon'      => $this->icon,
            'modal'     => $this->modal,
            'title'     => $this->title,
            'arguments' => $arguments,
        ]);
    }

    /**
     * @param $name
     * @param $property
     *
     * @return $this
     */
    protected function rewriteProperty($name, $property)
    {
        $this->$name = $property;

        return $this;
    }
}
