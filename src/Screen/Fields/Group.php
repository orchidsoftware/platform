<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Contracts\Fieldable;
use Orchid\Screen\Contracts\Groupable;
use Orchid\Screen\Field;

class Group implements Fieldable, Groupable
{
    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'group'       => [],
        'class'       => 'col-12 col-md form-group mb-md-0',
        'align'       => 'align-items-baseline',
        'itemToEnd'   => false,
    ];

    /**
     * Required Attributes.
     *
     * @var array
     */
    protected $required = [];

    /**
     * @var string
     */
    protected $view = 'platform::fields.group';

    /**
     * @param array $group
     *
     * @return static
     */
    public static function make(array $group = [])
    {
        return (new static())->setGroup($group);
    }

    /**
     * @return Field[]
     */
    public function getGroup(): array
    {
        return $this->get('group', []);
    }

    /**
     * @param array $group
     *
     * @return $this
     */
    public function setGroup(array $group = []): Groupable
    {
        return $this->set('group', $group);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view($this->view, $this->attributes);
    }

    /**
     * Columns only take up as much space as needed.
     *
     * @return self
     */
    public function autoWidth(): self
    {
        return $this->set('class', 'col-auto');
    }

    /**
     * Columns occupy the entire width of the screen.
     *
     * @return self
     */
    public function fullWidth(): self
    {
        return $this->set('class', 'col');
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return static
     */
    public function set(string $key, $value = true): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @param string     $key
     * @param mixed|null $value
     *
     * @return static|mixed|null
     */
    public function get(string $key, $value = null)
    {
        return $this->attributes[$key] ?? $value;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function form(string $name): self
    {
        $group = array_map(function ($field) use ($name) {
            return $field->form($name);
        }, $this->getGroup());

        return $this->setGroup($group);
    }

    /**
     * @return $this
     */
    public function alignBaseLine(): self
    {
        return $this->set('align', 'align-items-baseline');
    }

    /**
     * @return $this
     */
    public function alignCenter(): self
    {
        return $this->set('align', 'align-items-center');
    }

    /**
     * @return $this
     */
    public function alignEnd(): self
    {
        return $this->set('align', 'align-items-end');
    }

    /**
     * @return $this
     */
    public function alignStart(): self
    {
        return $this->set('align', 'align-items-end');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->render();
    }

    /**
     * @return $this
     */
    public function toEnd(): self
    {
        return $this->set('itemToEnd', true);
    }
}
