<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Repository;

class Builder
{
    /**
     * Fields to be reflected, in the form Field.
     *
     * @var
     */
    public $fields;

    /**
     * Transmitted values for display in a form.
     *
     * @var
     */
    public $data;

    /**
     * The form language.
     *
     * @var
     */
    public $language;

    /**
     * The form prefix.
     *
     * @var
     */
    public $prefix;

    /**
     * HTML form string.
     *
     * @var
     */
    public $form = '';

    /**
     * Builder constructor.
     *
     * @param array       $fields
     * @param Repository  $data
     * @param string|null $language
     * @param string|null $prefix
     */
    public function __construct(array $fields, Repository $data, string $language = null, string $prefix = null)
    {
        $this->fields = $fields;
        $this->data = $data;
        $this->language = $language;
        $this->prefix = $prefix;
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Generate a ready-made html form for display to the user.
     *
     * @throws \Throwable
     *
     * @return string
     */
    public function generateForm() : string
    {
        foreach ($this->fields as $field) {
            if (is_array($field)) {
                $this->renderGroup($field);
                continue;
            }

            $this->form .= $this->render($field);
        }

        return $this->form;
    }

    /**
     * @param $groupField
     *
     * @throws \Throwable
     */
    private function renderGroup($groupField)
    {
        foreach ($groupField as $field) {
            $group[] = $this->render($field);
        }

        $this->form .= view('platform::partials.fields.groups', [
            'cols' => $group ?? [],
        ])->render();
    }

    /**
     * Render field for forms.
     *
     * @param $field
     *
     * @return mixed
     */
    private function render($field)
    {
        $field->set('lang', $this->language);
        $field->set('prefix', $this->buildPrefix($field));

        foreach ($this->fill($field->getAttributes()) as $key => $value) {
            $field->set($key, $value);
        }

        return $field->render();
    }

    /**
     * @param $field
     *
     * @return string
     */
    private function buildPrefix($field)
    {
        $prefix = $field->get('prefix', null);

        if (!is_null($prefix)) {
            foreach (array_filter(explode(' ', $prefix)) as $name) {
                $prefix .= '['.$name.']';
            }

            return $prefix;
        }

        return $this->prefix;
    }

    /**
     * @param $attributes
     *
     * @return mixed
     */
    private function fill($attributes)
    {
        $name = array_filter(explode(' ', $attributes['name']));
        $name = array_shift($name);

        $attributes['value'] = $this->getValue($name, $attributes['value'] ?? null);

        $binding = explode('.', $name);
        if (!is_array($binding)) {
            return $attributes;
        }

        $attributes['name'] = '';
        foreach ($binding as $key => $bind) {
            if (!is_null($attributes['prefix'])) {
                $attributes['name'] .= '['.$bind.']';
                continue;
            }

            if ($key === 0) {
                $attributes['name'] .= $bind;
                continue;
            }

            $attributes['name'] .= '['.$bind.']';
        }

        return $attributes;
    }

    /**
     * Gets value of Repository.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    private function getValue(string $key, $value = null)
    {
        if (!is_null($this->language)) {
            $key = $this->language.'.'.$key;
        }

        if (!is_null($this->prefix)) {
            $key = $this->prefix.'.'.$key;
        }

        $data = $this->data->getContent($key);

        // default value
        if (is_null($data)) {
            return $value;
        }

        if (!is_null($value) && $value instanceof \Closure) {
            return $value($data, $this->data);
        }

        return $data;
    }
}
