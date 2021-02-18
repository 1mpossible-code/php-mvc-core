<?php


namespace app\core\form;


use app\core\Model;

/**
 * Class Form
 * @package app\core\form
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