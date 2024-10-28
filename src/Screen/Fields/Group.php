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
        'group'               => [],
        'class'               => 'col-12 col-md form-group mb-md-0',
        'align'               => 'align-items-baseline',
        'itemToEnd'           => false,
        'widthColumns'        => null,
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
     * @return static
     */
    public static function make(array $group = [])
    {
        return (new static)->setGroup($group);
    }

    /**
     * @return Field[]
     */
    public function getGroup(): array
    {
        return $this->get('group', []);
    }

    /**
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
     * Set the columns to automatically size based on their content.
     *
     * This method configures the columns to only take up as much width
     * as needed for their content. It achieves this by using the `max-content`
     * value in a CSS grid template, allowing each column to adjust dynamically
     * according to the size of its content.
     *
     * The number of columns is determined by counting the elements in the group,
     * and a repeat function is used to apply `max-content` for each column.
     *
     * @return $this Returns the current instance for method chaining.
     */
    public function autoWidth(): self
    {
        $countColumns = count($this->get('group'));

        return $this->set('widthColumns', sprintf('repeat(%s, max-content)', $countColumns));
    }

    /**
     * Set the columns to occupy the entire width of the screen.
     *
     * This method configures the columns to utilize the full available width,
     * effectively making them span across the entire width of the container.
     * By setting the width columns to null, it allows for a responsive layout
     * that adjusts based on screen size.
     *
     * @return $this Returns the current instance for method chaining.
     */
    public function fullWidth(): self
    {
        return $this->set('widthColumns', null);
    }

    /**
     * Set the width of the columns using a CSS grid template.
     *
     * This method allows you to define the column widths in a flexible way
     * by specifying a CSS grid template string. The template can include
     * various units such as percentages, pixels, or fractional units (fr).
     *
     * Example usage:
     * ```
     * // Define two columns with a 2:1 ratio
     * $group->widthColumns('8fr 4fr');
     *
     * // Set columns to specific pixel widths
     * $group->widthColumns('120px 300px');
     *
     * // Define columns with percentage widths
     * $group->widthColumns('30% 70%');
     *
     * // Use maximum content width for each column
     * $group->widthColumns('max-content max-content');
     *
     * // Create three equal columns
     * $group->widthColumns('1fr 1fr 1fr');
     *
     * // Use repeat to create four equal columns
     * $group->widthColumns('repeat(4, 1fr)');
     * ```
     *
     * @param string $template A string representing the CSS grid template
     *                         for the column widths. This should conform
     *                         to the CSS `grid-template-columns` specification.
     *
     * @return $this Returns the current instance for method chaining.
     */
    public function widthColumns(string $template): self
    {
        return $this->set('widthColumns', $template);
    }

    /**
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
     * @param mixed|null $value
     *
     * @return static|mixed|null
     */
    public function get(string $key, $value = null)
    {
        return $this->attributes[$key] ?? $value;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return $this
     */
    public function form(string $name): self
    {
        $group = array_map(fn ($field) => $field->form($name), $this->getGroup());

        return $this->setGroup($group);
    }

    /**
     * Align columns along their baseline.
     *
     * This method sets the vertical alignment of the columns to the baseline,
     * ensuring that the text aligns according to the baseline of the content.
     *
     * @return $this Returns the current instance for method chaining.
     */
    public function alignBaseLine(): self
    {
        return $this->set('align', 'align-items-baseline');
    }

    /**
     * Center align columns vertically.
     *
     * This method sets the vertical alignment of the columns to the center,
     * ensuring that all columns are aligned in the middle of the container.
     *
     * @return $this Returns the current instance for method chaining.
     */
    public function alignCenter(): self
    {
        return $this->set('align', 'align-items-center');
    }

    /**
     * Align columns to the end of the container.
     *
     * This method sets the vertical alignment of the columns to the end,
     * positioning all columns at the bottom of the container.
     *
     * @return $this Returns the current instance for method chaining.
     */
    public function alignEnd(): self
    {
        return $this->set('align', 'align-items-end');
    }

    /**
     * Align columns to the start of the container.
     *
     * This method sets the vertical alignment of the columns to the start,
     * positioning all columns at the top of the container.
     *
     * @return $this Returns the current instance for method chaining.
     */
    public function alignStart(): self
    {
        return $this->set('align', 'align-items-start');
    }

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
