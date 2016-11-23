<?php

namespace Orchid\Foundation\Services\Field;

abstract class Field  implements FieldInterface
{
    /**
     * @var
     */
    protected $id;


    /**
     * The name attribute specifies the name of an <input> element.
     * @var
     */
    protected $name = '';


    /**
     * The placeholder attribute specifies a short hint that describes the expected value of an input field.
     * The short hint is displayed in the input field before the user enters a value.
     * @var
     */
    protected $placeholder = '';


    /**
     * The required attribute is a boolean attribute.
     * When present, it specifies that an input field must be filled out before submitting the form.
     * @var
     */
    protected $required = 'false';



    /**
     * The value attribute specifies the value of an <input> element.
     * The value attribute is used differently for different input types:.
     * @var
     */
    protected $value;


    /**
     * View template show.
     * @var
     */
    public $view;

}
