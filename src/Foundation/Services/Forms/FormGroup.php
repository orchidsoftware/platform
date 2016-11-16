<?php

namespace Orchid\Foundation\Services\Forms;

abstract class FormGroup
{
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
    public $view;


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
     * FormGroup constructor.
     */
    public function __construct()
    {
        $registerForm = event(new $this->event($this));
        $this->group = collect($registerForm);
        $this->storage = collect();
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
        ]);
    }

    /**
     * @return string
     */
    public function save()
    {
        foreach ($this->group as $form) {
            if (! is_object($form)) {
                $form = new $form();
            }

            if (method_exists($form, 'save')) {
                $form->save($this->storage);
            }
        }
    }
}
