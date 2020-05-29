<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Contracts\Groupable;
use Orchid\Screen\Field;

class Group extends Field implements Groupable
{
    /**
     * @var Field[]
     */
    protected $group = [];

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'name'   => 'group',
        'class'  => 'col',
    ];

    /**
     * @var string
     */
    protected $view = 'platform::partials.fields.groups';

    /**
     * Group constructor.
     */
    public function __construct(array $group = [])
    {
        $this->group = $group;
    }

    /**
     * @param array $group
     *
     * @return static
     */
    public static function make(array $group = [])
    {
        return new static($group);
    }

    /**
     * @return Field[]
     */
    public function getGroup(): array
    {
        return $this->group;
    }

    /**
     * @param array $group
     *
     * @return array
     */
    public function setGroup(array $group = []): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function render()
    {
        return view($this->view, [
            'group'   => $this->group,
            'class'   => $this->get('class'),
        ]);
    }

    public function autoWidth(): self
    {
        $this->attributes['class'] = 'col-auto';

        return $this;
    }

    /**
     * @return $this
     */
    public function fullWidth(): self
    {
        $this->attributes['class'] = 'col';

        return $this;
    }
}
