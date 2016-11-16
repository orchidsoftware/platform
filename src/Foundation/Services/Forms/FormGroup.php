<?php

namespace Orchid\Foundation\Services\Forms;

abstract class FormGroup
{
    /**
     * Name form groups
     * @var
     */
    public $name = '';


    /**
     * Description form group
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
     *
     * @var \Illuminate\Support\Collection
     */
    public $storage;

    /**
     * Command list button
     * Send all forms data
     * @var
     */
    public $commands;


    /**
     * Route CRUD
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
        if(method_exists($this,'attributes')){
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
            if (!is_object($form)) {
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
            'description' => $this->description,
            'route' => collect($this->route),
            'model' => $this->storage->has('model') ? $this->storage->get('model') : null,
            'method' => $this->storage->has('model') ? 'update' : 'create',
            'slug' => $this->storage->has('model') ? $this->storage->get('model')->getRouteKeyName() : null,
        ]);
    }

    /**
     * @return string
     */
    public function save()
    {
        foreach ($this->group as $form) {
            if (!is_object($form)) {
                $form = new $form();
            }

            if (method_exists($form, 'save')) {
                $form->save($this->storage);
            }
        }
    }


    /**
     * Set All attributes class
     * @param $array
     */
    public function setAttributes($array){
        foreach ($array as $key => $value){
            $this->$key = $value;
        }
    }


    /**
     * Grid Generator
     * @return bool
     */
    public function grid(){
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
