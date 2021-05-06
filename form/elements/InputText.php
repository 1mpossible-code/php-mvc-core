<?php


namespace impossible\phpmvc\form\elements;


/**
 * Text type input
 * @package impossible\phpmvc\form\elements
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