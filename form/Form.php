<?php


namespace app\core\form;


use app\core\Model;

/**
 * Form Widget
 * @package app\core\form
 */
class Form
{
    /**
     * Form constructor.
     */
    public function __construct(string $action, string $method)
    {
        // Output form beginning tag
        echo sprintf( '<form action="%s" method="%s">' , $action, $method);
    }

    /**
     * Close the form tag
     */
    public function end(): void
    {
        // Output close form tag
        echo '</form>';
    }

    /**
     * Create new field for form
     * @param string $formElement
     * @param Model $model
     * @param string $attribute
     * @return FormElement
     */
    public function field(string $formElement, Model $model, string $attribute): FormElement
    {
        // Create new form element
        return new $formElement($model, $attribute);
    }

    /**
     * Outputs the submit button form element
     */
    public function submit()
    {
        // Output submit button
        echo '<button type="submit" class="btn btn-primary">Submit</button>';
    }

}