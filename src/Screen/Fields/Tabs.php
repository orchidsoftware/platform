<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Contracts\Fieldable;
use Orchid\Screen\Contracts\Tabable;
use Orchid\Screen\Field;

class Tabs implements Fieldable, Tabable
{
    public function __construct()
    {
        $this->attributes['templateSlug'] = $this->getSlug();
    }

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'tab' => [],
        'activeTab' => null,
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
    protected $view = 'platform::fields.tabs';

    /**
     * @param array $tab
     *
     * @return static
     */
    public static function make(array $tab = [])
    {
        return (new static())->setTab($tab);
    }

    /**
     * @return Field[]
     */
    public function getTab(): array
    {
        return $this->get('tab', []);
    }

    /**
     * @param array $tab
     *
     * @return $this
     */
    public function setTab(array $tab = []): Tabable
    {
        return $this->set('tab', $tab);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view($this->view, $this->attributes);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return static
     */
    public function set(string $key, $value = true): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
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
        }, $this->getTab());

        return $this->setTab($group);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->render();
    }

    public function getSlug(): string
    {
        return sha1(json_encode($this));
    }
}
