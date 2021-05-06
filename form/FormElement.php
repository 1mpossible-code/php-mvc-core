<?php


namespace impossible\phpmvc\form;


use impossible\phpmvc\Model;

/**
 * Class FormElement
 * @package impossible\phpmvc\form
 */
abstract class FormElement
{
    /**
     * @var Model
     */
    public Model $model;
    /**
     * @var string
     */
    public string $attribute;

    /**
     * Input constructor.
     */
    public function __construct(Model $model, string $attribute)
    {
        // Define model
        $this->model = $model;
        // Define attribute
        $this->attribute = $attribute;
        // Output element after data is given
        // when the instance is created
        $this->print();
    }

    /**
     * Define to output the element
     */
    abstract public function print(): void;
}