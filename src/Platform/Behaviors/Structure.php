<?php

declare(strict_types=1);

namespace Orchid\Platform\Behaviors;

use Illuminate\Support\Facades\Validator;

trait Structure
{
    /**
     * Visible name of behavior.
     *
     * @var
     */
    public $name = '';

    /**
     * Visible description of behavior.
     *
     * @var string
     */
    public $description = '';

    /**
     * A unique name for behavior.
     *
     * @var string
     */
    public $slug = '';

    /**
     * Display Icon.
     *
     * @var string
     */
    public $icon = 'fa fa-folder-o';

    /**
     * Fields for content.
     *
     * @var array
     */
    public $fields = [];

    /**
     * @var string
     */
    public $prefix = 'content';

    /**
     * Menu group name.
     *
     * @var null
     */
    public $groupname = null;

    /**
     * Status divider.
     *
     * @var bool
     */
    public $divider = false;

    /**
     * Container for HTML render.
     *
     * @var null
     */
    private $cultivated = null;

    /**
     * Basic statuses possible for the object.
     *
     * @return array
     */
    public function status()
    {
        return [
            'publish' => trans('dashboard::post/base.status_list.publish'),
            'draft'   => trans('dashboard::post/base.status_list.draft'),
        ];
    }

    /**
     * Request Validation.
     *
     * @return bool
     */
    public function isValid() : bool
    {
        Validator::make(request()->all(), $this->rules())->validate();

        return true;
    }

    /**
     * Validation Request Rules.
     *
     * @return array
     */
    public function rules() : array
    {
        return [];
    }

    /**
     * All registered extensions specified in the behavior.
     *
     * @return array
     */
    public function getModules() : array
    {
        if ($this->checkModules()) {
            return $this->modules();
        }

        return [];
    }

    /**
     * Check for a registered extension in the behavior.
     *
     * @return bool
     */
    public function checkModules() : bool
    {
        if (method_exists($this, 'modules') && ! empty($this->modules())) {
            return true;
        }

        return false;
    }

    /**
     * Display html forms of registered extensions.
     *
     * @return string
     */
    public function render()
    {
        if (! is_null($this->cultivated)) {
            return $this->cultivated;
        }

        $html = collect();
        $groups = $this->modules();

        $argc = array_values(request()->getRouteResolver()->call($this)->parameters());

        foreach ($groups as $form) {
            if (! is_object($form)) {
                $form = new $form();
            }
            if (method_exists($form, 'get')) {
                $html->put($form->name, $form->get(...$argc));
            }
        }

        $this->cultivated = $html;

        return $this->cultivated;
    }

    /**
     * Action save for sub form.
     */
    public function save()
    {
        $arg = func_get_args();

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
     * Action update for sub form.
     */
    public function update()
    {
        $arg = func_get_args();

        foreach ($this->group as $form) {
            if (! is_object($form)) {
                $form = new $form();
            }

            if (method_exists($form, 'update')) {
                $form->save(...$arg);
            }
        }
    }

    /**
     * Action remove for sub form.
     */
    public function remove()
    {
        $arg = func_get_args();

        foreach ($this->group as $form) {
            if (! is_object($form)) {
                $form = new $form();
            }

            if (method_exists($form, 'delete')) {
                $form->delete(...$arg);
            }
        }
    }
}
