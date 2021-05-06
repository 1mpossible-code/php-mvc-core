<?php


namespace app\core\form\elements;


use app\core\form\FormElement;

/**
 * Base input class
 * @package app\core\form\elements
 */
abstract class Input extends FormElement
{
    /**
     * The variable to define the type of input
     * @return string
     */
    abstract public function type(): string;

    /**
     * Output input
     */
    public function print(): void
    {
        // Get label from model labels list
        $label = $this->model->getLabel($this->attribute);
        // Get type
        $type = $this->type();
        // Name of attribute that is used in request
        $name = $this->attribute;
        // Get already loaded data from model
        $value = $this->model->{$this->attribute};
        // If has error set additional class 'is-invalid' or empty if not
        $additionalClass = $this->model->hasError($this->attribute) ? 'is-invalid' : '';
        // Get error for feedback if has one
        $feedback = $this->model->getFirstError($this->attribute);
        // Output input with defined data
        echo sprintf('
        <div class="mb-3">
            <label class="form-label">%s</label>
            <input type="%s" name="%s" value="%s" class="form-control %s">
            <div class="invalid-feedback">%s</div>
        </div>
        ',
            $label,
            $type,
            $name,
            $value,
            $additionalClass,
            $feedback,
        );
    }
}