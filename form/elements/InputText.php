<?php


namespace app\core\form\elements;


/**
 * Text type input
 * @package app\core\form\elements
 */
class InputText extends Input
{
    /**
     * @return string
     */
    public function type(): string
    {
        return 'text';
    }
}