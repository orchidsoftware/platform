<?php

namespace Orchid\Platform\Fields;

use Orchid\Platform\Exceptions\TypeException;
use Orchid\Platform\Exceptions\FieldRequiredAttributeException;

class Field implements FieldContract
{
    /**
     * View template show.
     *
     * @var
     */
    public $view;

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];

    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $old;

    /**
     * @var
     */
    public $error;

    /**
     * @var
     */
    public $slug;

    /**
     * @param string $type
     *
     * @return FieldContract
     * @throws TypeException
     */
    public static function tag(string $type) : FieldContract
    {
        $field = config('platform.fields.'.$type);

        if (! is_subclass_of($field, FieldContract::class)) {
            throw new TypeException('Field '.$type.' does not exist or inheritance FieldContract');
        }

        return new $field();
    }

    /**
     * @param $arguments
     *
     * @return FieldContract
     * @throws TypeException
     */
    public static function make($arguments)
    {
        $field = self::tag($arguments['tag']);

        foreach ($arguments as $key => $value) {
            $field->set($key, $value);
        }

        return $field;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            call_user_func_array([$this, $name], [$arguments]);
        }

        return call_user_func_array([$this, 'set'], [$name, array_shift($arguments) ?? true]);
    }

    /**
     * @param      $key
     * @param null $value
     *
     * @return $this|mixed|null
     */
    public function get($key, $value = null)
    {
        if (! isset($this->attributes[$key])) {
            return $value;
        }

        return $this->attributes[$key];
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function set($key, $value = true)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * Obtain the list of required fields.
     *
     * @return array
     */
    public function getRequired() : array
    {
        return $this->required;
    }

    /**
     * Get the name of the template.
     *
     * @return string
     */
    public function getView() : string
    {
        return $this->view;
    }

    /**
     * @return mixed|void
     * @throws FieldRequiredAttributeException
     */
    public function checkRequired()
    {
        foreach ($this->required as $attribute) {
            if (! $this->attributes->offsetExists($attribute)) {
                throw new FieldRequiredAttributeException('Field must have the following attribute: '.$attribute);
            }
        }
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return str_slug($this->get('name'));
    }

    /**
     * @return string
     */
    public function getId()
    {
        $lang = $this->get('lang');
        $slug = $this->getSlug('slug');

        return "field-$lang-$slug";
    }

    /**
     * @return string
     */
    public function getName()
    {
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');
        $name = $this->get('name');

        if (is_null($prefix)) {
            return $lang.$name;
        }

        return $prefix.'['.$lang.']'.$name;
    }

    /**
     * @return string
     */
    public function getOldName()
    {
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');
        $name = str_ireplace(['[', ']'], '', $this->get('name'));

        if (is_null($prefix)) {
            return $lang.'.'.$name;
        }

        return $prefix.'.'.$lang.'.'.$name;
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return old($this->getOldName());
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return optional(session('errors'))->has($this->getOldName()) ?? false;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function render()
    {
        /*
        $this->id = $this->getId();
        $this->name = $this->getName();
        $this->old = $this->getOldValue();
        $this->error = $this->hasError();
        $this->slug = $this->getSlug();
        */

        // TODO: Изменить внедрнение параметров!

        return view($this->view, array_merge($this->getAttributes(), [
            'id'      => $this->getId(),
            'fieldName'    => $this->getName(),
            'old'     => $this->getOldValue(),
            'error'   => $this->hasError(),
            'slug'    => $this->getSlug(),
            'oldName' => $this->getOldName(),
        ]));
    }
}
