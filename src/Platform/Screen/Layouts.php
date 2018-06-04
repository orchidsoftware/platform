<?php

declare(strict_types=1);

namespace Orchid\Platform\Screen;

/**
 * Class Layouts
 *
 * @method static Layouts tabs(array $name)
 * @method static Layouts columns(array $name)
 * @method static Layouts modals(array $name)
 * @method static Layouts div(array $name)
 * @method static Layouts view(string $name)
 */
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
        'tabs'    => 'platform::container.layouts.tabs',
        'columns' => 'platform::container.layouts.columns',
        'modals'  => 'platform::container.layouts.modals',
        'div'     => 'platform::container.layouts.div',
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
     * @throws \Throwable
     *
     * @return array
     */
    public function build($post)
    {
        if (is_string($this->layouts)) {

            $params = $post->toArray();
            $params['compose'] = $this->compose;

            return view($this->layouts, $params);
        }

        foreach ($this->layouts as $key => $layouts) {
            foreach ($layouts as $layout) {
                $build[$key][] = is_object($layout) ? $layout->build($post) : (new $layout())->build($post);
            }
        }

        return view($this->templates[$this->active], [
            'manyForms' => $build ?? [],
            'compose'   => $this->compose,
        ]);
    }
}
