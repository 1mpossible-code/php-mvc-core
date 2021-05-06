<?php


namespace impossible\phpmvc\form\elements;


/**
 * Email type input
 * @package impossible\phpmvc\form\elements
 */
class InputEmail extends Input
{
    /**
     * @return string
     */
    public function type(): string
    {
        return 'email';
    }
}