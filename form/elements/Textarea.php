<?php


namespace app\core\form\elements;


use app\core\form\FormElement;

/**
 * Base input class
 * @package app\core\form\elements
 */
class Textarea extends FormElement
{
    /**
     * Output textarea
     */
    public function print(): void
    {
        // Get label from model labels list
        $label = $this->model->getLabel($this->attribute);
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
            <textarea name="%s" class="form-control %s">%s</textarea>
            <div class="invalid-feedback">%s</div>
        </div>
        ',
            $label,
            $name,
            $additionalClass,
            $value,
            $feedback,
        );
    }
}