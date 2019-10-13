<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class ViewField.
 *
 * @method ViewField name(string $value = null)
 * @method ViewField help(string $value = null)
 */
class ViewField extends Field
{
    /**
     * Required Attributes.
     *
     * @var array
     */
    protected $required = [
        'view',
    ];

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accept',
        'accesskey',
        'autocomplete',
        'autofocus',
        'checked',
        'disabled',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'language',
        'lineNumbers',
        'list',
        'max',
        'maxlength',
        'min',
        'name',
        'pattern',
        'placeholder',
        'readonly',
        'required',
        'size',
        'src',
        'step',
        'tabindex',
        'type',
        'value',
    ];

    /**
     * @param string $view
     *
     * @return self
     */
    public function view(string $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @param string|null $name
     *
     * @return ViewField
     */
    public static function make(string  $name = null): self
    {
        return (new static())->name($name);
    }
}
