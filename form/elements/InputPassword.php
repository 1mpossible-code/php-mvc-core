<?php


namespace impossible\phpmvc\form\elements;


/**
 * Password type input
 * @package impossible\phpmvc\form\elements
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