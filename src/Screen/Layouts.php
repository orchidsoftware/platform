<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Layouts\Rows;

/**
 * Class Layouts.
 *
 * @method static Layouts tabs(array $name)
 * @method static Layouts columns(array $name)
 * @method static Layouts modals(array $name)
 * @method static Layouts div(array $name)
 */
class Layouts
{
    /**
     * @var string
     */
    public $active;

    /**
     * @var array
     */
    public $templates = [
        'tabs'    => 'platform::container.layouts.tabs',
        'columns' => 'platform::container.layouts.columns',
        'modals'  => 'platform::container.layouts.modals',
        'blank'   => 'platform::container.layouts.blank',
    ];

    /**
     * @var array
     */
    public $layouts = [];

    /**
     * @var string
     */
    public $asyncMethod;

    /**
     * @var string
     */
    public $asyncRoute;

    /**
     * @var bool
     */
    public $async = false;

    /**
     * @var
     */
    public $slug;

    /**
     * @var array
     */
    public $compose = [];

    /**
     * Layouts constructor.
     */
    public function __construct()
    {
        $this->slug = sha1(serialize($this));
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $new = new static;
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
     * @return $this
     *
     * @throws \ReflectionException
     */
    protected function setLayouts($property)
    {
        $this->layouts = $property;

        if ((new \ReflectionClass($this))->isAnonymous()) {
            $this->slug = sha1(serialize($this));
        }

        return $this;
    }

    /**
     * @param \Orchid\Screen\Repository $repository
     * @param bool $async
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build(Repository $repository, $async = false)
    {
        $build = [];

        foreach ($this->layouts as $key => $layouts) {
            $layouts = ! is_array($layouts) ? [$layouts] : $layouts;

            foreach ($layouts as $layout) {
                $layout = ! is_object($layout) ? new $layout : $layout;

                if (is_a($layout, self::class) && $layout->active === 'view') {
                    $build[$key][] = view($layout->templates[$layout->active], $repository->toArray());
                    continue;
                }

                /*
                 * Check permissions
                 */
                if (method_exists($layout, 'canSee') && ! $layout->canSee($repository)) {
                    continue;
                }

                $build[$key][] = $layout->build($repository);
            }
        }

        return view($async ? 'platform::container.layouts.blank' : $this->templates[$this->active], [
            'manyForms'           => $build ?? [],
            'compose'             => $this->compose,
            'templateSlug'        => $this->slug,
            'templateAsync'       => $this->async,
            'templateAsyncMethod' => $this->asyncMethod,
            'templateAsyncRoute'  => $this->asyncRoute,
        ]);
    }

    /**
     * @param string $method
     * @param bool $async
     *
     * @return \Orchid\Screen\Layouts
     */
    public function async(string $method, $async = true): self
    {
        $this->async = $async;
        $this->asyncMethod = $method;

        return $this;
    }

    /**
     * @param string $route
     *
     * @return \Orchid\Screen\Layouts
     */
    public function route(string $route): self
    {
        $this->asyncRoute = $route;

        return $this;
    }

    /**
     * @param string $view
     *
     * @return static
     */
    public static function view(string $view)
    {
        $new = new static;
        $new->active = 'view';
        $new->templates['view'] = $view;
        $new->slug = sha1(serialize($new));

        return $new;
    }

    /**
     * @param array $fields
     *
     * @return Rows
     */
    public static function rows(array $fields): Rows
    {
        return new class($fields) extends Rows {
            /**
             * @var array
             */
            private $fields;

            /**
             *  constructor.
             *
             * @param array $fields
             */
            public function __construct(array $fields)
            {
                $this->fields = $fields;
            }

            /**
             * @return array
             */
            public function fields(): array
            {
                return $this->fields;
            }
        };
    }
}
