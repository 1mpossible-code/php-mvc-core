<?php


namespace impossible\phpmvc\form;


use impossible\phpmvc\Model;

/**
 * Class Form
 * @package impossible\phpmvc\form
 */
class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new self();
    }

    public static function end()
    {
        return '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }

}