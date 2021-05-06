<?php


namespace app\core\form\elements;


/**
 * Email type input
 * @package app\core\form\elements
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