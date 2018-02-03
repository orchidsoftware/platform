<?php

declare(strict_types=1);

namespace Orchid\Platform\Forms;

use Illuminate\View\View;

abstract class FormGroup
{
    /**
     * Name form groups.
     *
     * @var
     */
    public $name = '';

    /**
     * Icon tabs.
     *
     * @var string
     */
    public $icon = '';

    /**
     * Description form group.
     *
     * @var
     */
    public $description = '';

    /**
     * Collection listeners form.
     *
     * @var \Illuminate\Support\Collection
     */
    public $group;

    /**
     * View template form.
     *
     * @var
     */
    public $view = 'dashboard::layouts.form.group';

    /**
     * @var
     */
    public $method = 'GET';

    /**
     * Command list button
     * Send all forms data.
     *
     * @var
     */
    public $commands;

    /**
     * Route CRUD.
     *
     * @var array
     */
    public $route = '';

    /**
     * @var string
     */
    public $slug = '';

    /**
     * Event Hook.
     *
     * @var
     */
    protected $event;

    /**
     * Views Render.
     *
     * @var
     */
    private $html;

    /**
     * FormGroup constructor.
     */
    public function __construct()
    {
        $registerForm = event(new $this->event($this));
        $this->group = collect($registerForm)->filter(function ($item) {
            return ! is_null($item) || ! empty($item);
        });
        $this->commands = collect();
        $this->html = collect();

        // Attributes property
        if (method_exists($this, 'attributes')) {
            $this->setAttributes($this->attributes());
        }
    }

    /**
     * Set All attributes class.
     *
     * @param $array
     */
    public function setAttributes($array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @param array ...$arg
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(...$arg) : View
    {
        foreach ($this->group as $form) {
            $form = app()->make($form);

            if (method_exists($form, 'get')) {
                $this->html->put($form->name, $form->get(...$arg));
            }
        }

        return view($this->view, [
            'forms'       => $this->html,
            'name'        => $this->name,
            'icon'        => $this->icon,
            'description' => $this->description,
            'route'       => $this->route,
            'slug'        => $this->slug,
            'method'      => $this->method,
        ]);
    }

    /**
     * Action save for sub form.
     *
     * @param array ...$arg
     */
    public function save(...$arg)
    {
        foreach ($this->group as $form) {
            $form = app()->make($form);

            if (method_exists($form, 'save')) {
                $form->save(...$arg);
            }
        }
    }

    /**
     * Action save for sub form.
     *
     * @param array $arg
     */
    public function remove(...$arg)
    {
        foreach ($this->group as $form) {
            $form = app()->make($form);

            if (method_exists($form, 'delete')) {
                $form->delete(...$arg);
            }
        }
    }

    /**
     * Grid Generator.
     *
     * @param array ...$arg
     *
     * @return bool
     */
    public function grid(...$arg)
    {
        if (method_exists($this, 'main')) {
            $table = $this->main(...$arg);
            $table->name = $this->name;
            $table->description = $this->description;
            $table->route = $this->route;

            return $table;
        }

        return false;
    }

    /**
     * @param $method
     *
     * @return FormGroup
     */
    public function method(string $method) : self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param $method
     *
     * @return FormGroup
     */
    public function route(string $method) : self
    {
        $this->route = $method;

        return $this;
    }

    /**
     * @param string|int $method
     *
     * @return FormGroup
     */
    public function slug($method) : self
    {
        $this->slug = $method;

        return $this;
    }
}
