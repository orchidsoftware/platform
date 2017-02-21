<?php

namespace Orchid\Field;

abstract class Field implements FieldInterface
{
    /**
     * @var
     */
    protected $id;

    /**
     * The name attribute specifies the name of an <input> element.
     *
     * @var
     */
    protected $name = '';

    /**
     * The placeholder attribute specifies a short hint that describes the expected value of an input field.
     * The short hint is displayed in the input field before the user enters a value.
     *
     * @var
     */
    protected $placeholder = '';

    /**
     * The required attribute is a boolean attribute.
     * When present, it specifies that an input field must be filled out before submitting the form.
     *
     * @var
     */
    protected $required = 'false';

    /**
     * The value attribute specifies the value of an <input> element.
     * The value attribute is used differently for different input types:.
     *
     * @var
     */
    protected $value;

    /**
     * View template show.
     *
     * @var
     */
    public $view;

    /**
     * HTML tag.
     *
     * @var string
     */
    protected $tag = 'input';
    /**
     * The type attribute specifies the type of <input> element to display.
     * The default type is: text.
     *
     * @var array
     */
    protected $type = [
        'button',
        'checkbox',
        'color',
        'date',
        'datetime',
        'datetime-local',
        'email',
        'file',
        'hidden',
        'image',
        'month',
        'number',
        'password',
        'radio',
        'range',
        'reset',
        'search',
        'submit',
        'tel',
        'text',
        'time',
        'url',
        'week',
    ];

    /**
     * The max attribute specifies the maximum value for an <input> element.
     * Use the max attribute together with the min attribute to create a range of legal values.
     *
     * @var
     */
    protected $max;

    /**
     * The min attribute specifies the minimum value for an <input> element.
     * Use the min attribute together with the max attribute to create a range of legal values.
     *
     * @var
     */
    protected $min;

    /**
     * The maxlength attribute specifies the maximum number of characters allowed in the <input> element.
     *
     * @var
     */
    protected $maxlength;

    /**
     * The checked attribute is a boolean attribute.
     * When present, it specifies that an <input> element should be pre-selected (checked) when the page loads.
     *
     * @var
     */
    protected $checked;
}
