<?php


namespace app\core\form\elements;


/**
 * Password type input
 * @package app\core\form\elements
 */
class InputPassword extends Input
{
    /**
     * @return string
     */
    public function type(): string
    {
        return 'password';
    }
}