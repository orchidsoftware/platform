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
     * Universal attributes are applied to almost all tags,
     * so they are allocated to a separate group so that they do not repeat for all tags.
     *
     * @var array
     */
    public $universalAttributes = [
        'accesskey',
        'class',
        'contenteditable',
        'contextmenu',
        'dir',
        'hidden',
        'id',
        'lang',
        'spellcheck',
        'style',
        'tabindex',
        'title',
        'xml:lang',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [];

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
            if (! collect($this->attributes)->offsetExists($attribute)) {
                throw new FieldRequiredAttributeException('Field must have the following attribute: '.$attribute);
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws FieldRequiredAttributeException
     */
    public function render()
    {
        $this->checkRequired();

        // TODO: Указать параметры в шаблонах, что бы не приходилось проверять на ошибки и т.п.

        $attributes = $this->getModifyAttributes();
        $attributes['id'] = $this->getId();

        return view($this->view, array_merge($this->getAttributes(), [
            'attributes' => $attributes,
            'id'         => $this->getId(),
            'fieldName'  => $this->getName(),
            'old'        => $this->getOldValue(),
            'error'      => $this->hasError(),
            'slug'       => $this->getSlug(),
            'oldName'    => $this->getOldName(),
        ]));
    }

    /**
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getModifyAttributes()
    {
        $modifiers = get_class_methods($this);

        return collect($this->getAttributes())->only(array_merge($this->universalAttributes,
            $this->inlineAttributes))->map(function ($item, $key) use ($modifiers) {
                $signature = 'modify'.title_case($key);
                if (in_array($signature, $modifiers)) {
                    return $this->$signature($item);
                }

                return $item;
            })->toArray();
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
     * @return string
     */
    public function getSlug()
    {
        return str_slug($this->get('name'));
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return old($this->getOldName());
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
     * @return bool
     */
    public function hasError()
    {
        return optional(session('errors'))->has($this->getOldName()) ?? false;
    }

    /**
     * @return array
     */
    public function getOriginalAttributes()
    {
        return array_except($this->getAttributes(), array_merge($this->universalAttributes, $this->inlineAttributes));
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function modifyName($name)
    {
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');

        if (is_null($prefix)) {
            return $lang.$name;
        }

        return $prefix.'['.$lang.']'.$name;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function modifyValue($value)
    {
        $old = $this->getOldValue();

        if (! is_null($old)) {
            return $old;
        }

        if ($value instanceof \Closure) {
            return $value();
        }

        return $value;
    }
}
