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
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $new = new Link();

        return call_user_func_array([$new, $name], $arguments);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this, $name], $arguments);
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
            'arguments' => $arguments,
        ]);
    }

    /**
     * @param $name
     *
     * @return $this
     */
    protected function name($name)
    {
        $this->slug = str_slug($name);
        $this->name = $name;

        return $this;
    }

    /**
     * @param $method
     *
     * @return $this
     */
    protected function method($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param $url
     *
     * @return $this
     */
    protected function url($url)
    {
        $this->url = $url;

        return $this;
    }
}
