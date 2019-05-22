<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * @deprecated
 *
 * Class ViewField.
 *
 * @method self name(string $value = null)
 * @method self help(string $value = null)
 */
class ViewField extends Field
{
    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'view',
    ];

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
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
