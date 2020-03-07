<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Contracts\Fieldable;
use Throwable;

class Builder
{
    /**
     * Fields to be reflected, in the form Field.
     *
     * @var Fieldable[]|mixed
     */
    public $fields;

    /**
     * Transmitted values for display in a form.
     *
     * @var Model|Repository
     */
    public $data;

    /**
     * The form language.
     *
     * @var string|null
     */
    public $language;

    /**
     * The form prefix.
     *
     * @var string|null
     */
    public $prefix;

    /**
     * HTML form string.
     *
     * @var string
     */
    private $form = '';

    /**
     * Builder constructor.
     *
     * @param Fieldable[] $fields
     * @param Repository  $data
     */
    public function __construct(array $fields, $data = null)
    {
        $this->fields = $fields;
        $this->data = $data ?? new Repository();
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage(string $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix(string $prefix = null): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Generate a ready-made html form for display to the user.
     *
     * @throws Throwable
     *
     * @return string
     */
    public function generateForm(): string
    {
        collect($this->fields)->each(function ($field) {
            $this->form .= is_array($field)
                ? $this->renderGroup($field)
                : $this->render($field);
        });

        return $this->form;
    }

    /**
     * @param Field[] $groupField
     *
     * @throws \Throwable
     *
     * @return array|string
     */
    private function renderGroup(array $groupField)
    {
        $cols = collect($groupField)->map(function ($field) {
            return $this->render($field);
        })->filter();

        return view('platform::partials.fields.groups', [
            'cols' => $cols,
        ])->render();
    }

    /**
     * Render field for forms.
     *
     * @param Field $field
     *
     * @throws Throwable
     *
     * @return mixed
     */
    private function render(Field $field)
    {
        $field->set('lang', $this->language);
        $field->set('prefix', $this->buildPrefix($field));

        foreach ($this->fill($field->getAttributes()) as $key => $value) {
            $field->set($key, $value);
        }

        return $field->render();
    }

    /**
     * @param Field $field
     *
     * @return string|null
     */
    private function buildPrefix(Field $field)
    {
        $prefix = $field->get('prefix');

        if (is_null($prefix)) {
            return $this->prefix;
        }

        return $prefix;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    private function fill(array $attributes)
    {
        $name = array_filter(explode(' ', $attributes['name']));
        $name = array_shift($name);

        $bindValueName = $name;
        if (substr($name, -1) === '.') {
            $bindValueName = substr($bindValueName, 0, -1);
        }

        $attributes['value'] = $this->getValue($bindValueName, $attributes['value'] ?? null);

        $binding = explode('.', $name);

        $attributes['name'] = '';
        foreach ($binding as $key => $bind) {
            if (! is_null($attributes['prefix'])) {
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
     * @param string     $key
     * @param mixed|null $value
     *
     * @return mixed
     */
    private function getValue(string $key, $value = null)
    {
        if (! is_null($this->language)) {
            $key = $this->language.'.'.$key;
        }

        if (! is_null($this->prefix)) {
            $key = $this->prefix.'.'.$key;
        }

        $data = $this->data->getContent($key);

        // default value
        if (is_null($data)) {
            return $value;
        }

        if ($value instanceof Closure) {
            return $value($data, $this->data);
        }

        return $data;
    }
}
