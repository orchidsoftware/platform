<?php

namespace Orchid\Forms;

abstract class FormGroup
{
    /**
     * Name form groups.
     * @var
     */
    public $name = '';

    /**
     * Icon tabs.
     * @var string
     */
    public $icon = '';

    /**
     * Description form group.
     * @var
     */
    public $description = '';

    /**
     * Event Hook.
     *
     * @var
     */
    protected $event;

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
     * Views Render.
     *
     * @var
     */
    private $html;

    /**
     * Global Forms Storage.
     * Deprecated.
     * @var \Illuminate\Support\Collection
     */
    public $storage;

    /**
     * Command list button
     * Send all forms data.
     * @var
     */
    public $commands;

    /**
     * Route CRUD.
     * @var array
     */
    public $route = [];

    /**
     * FormGroup constructor.
     */
    public function __construct()
    {
        $registerForm = event(new $this->event($this));
        $this->group = collect($registerForm);
        $this->storage = collect();
        $this->commands = collect();

        // Attributes property
        if (method_exists($this, 'attributes')) {
            $this->setAttributes($this->attributes());
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->html = collect();

        foreach ($this->group as $form) {
            if (! is_object($form)) {
                $form = new $form();
            }

            if (method_exists($form, 'get')) {
                $this->html->put($form->name, $form->get($this->storage));
            }
        }

        return view($this->view, [
            'forms' => $this->html,
            'storage' => $this->storage,
            'name' => $this->name,
            'icon' => $this->icon,
            'description' => $this->description,
            'route' => collect($this->route),
            'model' => $this->storage->has('model') ? $this->storage->get('model') : null,
            'method' => $this->storage->has('model') ? 'update' : 'create',
            'slug' => $this->storage->has('model') ? $this->storage->get('model')->getRouteKeyName() : null,
        ]);
    }

    /**
     * Action save for sub form.
     */
    public function save()
    {
        $arg = func_get_args();
        $arg[] = $this->storage;

        foreach ($this->group as $form) {
            if (! is_object($form)) {
                $form = new $form();
            }

            if (method_exists($form, 'save')) {
                $form->save(...$arg);
            }
        }
    }

    /**
     * Action save for sub form.
     */
    public function remove()
    {
        $arg = func_get_args();
        $arg[] = $this->storage;

        foreach ($this->group as $form) {
            if (! is_object($form)) {
                $form = new $form();
            }

            if (method_exists($form, 'delete')) {
                $form->delete(...$arg);
            }
        }
    }

    /**
     * Set All attributes class.
     * @param $array
     */
    public function setAttributes($array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Grid Generator.
     * @return bool
     */
    public function grid()
    {
        if (method_exists($this, 'main')) {
            $table = $this->main();
            $table->name = $this->name;
            $table->description = $this->description;
            $table->route = collect($this->route);

            return $table;
        }

        return false;
    }
}
