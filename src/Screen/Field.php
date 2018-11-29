<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Contracts\FieldContract;
use Orchid\Screen\Exceptions\FieldRequiredAttributeException;

/**
 * Class Field.
 *
 * @method $this accesskey($value = true)
 * @method $this type($value = true)
 * @method $this class($value = true)
 * @method $this contenteditable($value = true)
 * @method $this contextmenu($value = true)
 * @method $this dir($value = true)
 * @method $this hidden($value = true)
 * @method $this id($value = true)
 * @method $this lang($value = true)
 * @method $this spellcheck($value = true)
 * @method $this style($value = true)
 * @method $this tabindex($value = true)
 * @method $this title($value = true)
 * @method $this options($value = true)
 */
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
    public $attributes = [
        'value' => null,
    ];

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
     * Vertical or Horizontal
     * bootstrap forms.
     *
     * @var string
     */
    public $typeForm;

    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     *
     * @var array
     */
    public $translations = [
        'title',
        'placeholder',
        'help',
    ];

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
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        foreach ($arguments as $key => $argument) {
            if ($argument instanceof \Closure) {
                $arguments[$key] = $argument();
            }
        }

        if (method_exists($this, $name)) {
            $this->$name($arguments);
        }

        return $this->set($name, array_shift($arguments) ?? true);
    }

    /**
     * @param $value
     * @return $this
     */
    public function value($value): self
    {
        $this->attributes['value'] = $value;

        return $this;
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
    public function getRequired(): array
    {
        return $this->required;
    }

    /**
     * Get the name of the template.
     *
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @return $this|mixed
     * @throws \Throwable
     */
    public function checkRequired()
    {
        foreach ($this->required as $attribute) {
            throw_if(! collect($this->attributes)->offsetExists($attribute),
                FieldRequiredAttributeException::class, $attribute);
        }

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     *
     * @throws \Throwable
     */
    public function render()
    {
        $this->checkRequired();
        $this->translate();

        $attributes = $this->getModifyAttributes();
        $this->attributes['id'] = $this->getId();

        if ($this->hasError()) {
            if (! isset($attributes['class']) || is_null($attributes['class'])) {
                $attributes['class'] = ' is-invalid';
            } else {
                $attributes['class'] .= ' is-invalid';
            }
        }

        return view($this->view, array_merge($this->getAttributes(), [
            'attributes' => $attributes,
            'id'         => $this->getId(),
            'old'        => $this->getOldValue(),
            'slug'       => $this->getSlug(),
            'oldName'    => $this->getOldName(),
            'typeForm'   => $this->typeForm ?? $this->vertical()->typeForm,
        ]));
    }

    /**
     * Localization of fields.
     *
     * @return $this
     */
    private function translate(): self
    {
        if (empty($this->translations)) {
            return $this;
        }

        $lang = $this->get('lang');

        foreach ($this->attributes as $key => $attribute) {
            if (in_array($key, $this->translations, true)) {
                $this->set($key, __($attribute, [], $lang));
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getModifyAttributes()
    {
        $modifiers = get_class_methods($this);

        collect($this->getAttributes())->only(array_merge($this->universalAttributes,
            $this->inlineAttributes))->map(function ($item, $key) use ($modifiers) {
                $key = title_case($key);
                $signature = 'modify'.$key;
                if (in_array($signature, $modifiers, true)) {
                    $this->attributes[$key] = $this->$signature($item);
                }
            });

        return collect($this->getAttributes())
            ->only(array_merge($this->universalAttributes, $this->inlineAttributes));
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        $lang = $this->get('lang');
        $slug = $this->getSlug();

        return "field-$lang-$slug";
    }

    /**
     * @param      string $key
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
    public function getSlug(): string
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
    public function getOldName(): string
    {
        $name = str_ireplace(['][', '['], '.', $this->get('name'));
        $name = str_ireplace([']'], '', $name);

        return $name;
    }

    /**
     * @return bool
     */
    private function hasError(): bool
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
     * @return Field
     */
    public function modifyName($name)
    {
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');

        $this->attributes['name'] = $name;

        if (! is_null($prefix)) {
            $this->attributes['name'] = $prefix.$name;
        }

        if (is_null($prefix) && ! is_null($lang)) {
            $this->attributes['name'] = $lang.$name;
        }

        if (! is_null($prefix) && ! is_null($lang)) {
            $this->attributes['name'] = $prefix.'['.$lang.']'.$name;
        }

        if ($name instanceof \Closure) {
            $this->attributes['name'] = $name($this->attributes);
        }

        return $this;
    }

    /**
     * @param $value
     *
     * @return Field
     */
    public function modifyValue($value)
    {
        $this->attributes['value'] = $this->getOldValue() ?: $value;

        if ($value instanceof \Closure) {
            $this->attributes['value'] = $value($this->attributes);
        }

        return $this;
    }

    /**
     * @param \Closure|array $group
     *
     * @return mixed
     */
    public static function group($group)
    {
        if (! is_array($group)) {
            return call_user_func($group);
        }

        return $group;
    }

    /**
     * @return $this
     */
    public function vertical(): self
    {
        $this->typeForm = 'platform::partials.fields.vertical';

        return $this;
    }

    /**
     * @return $this
     */
    public function horizontal(): self
    {
        $this->typeForm = 'platform::partials.fields.horizontal';

        return $this;
    }

    /**
     * @return \Orchid\Screen\Field
     */
    public function hr(): self
    {
        $this->set('hr');

        return $this;
    }
}
