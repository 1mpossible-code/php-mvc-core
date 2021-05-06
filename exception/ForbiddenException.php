<?php


namespace impossible\phpmvc\exception;


/**
 * Class ForbiddenException
 * @package impossible\phpmvc\exception
 */
class ForbiddenException extends \Exception
{
    /**
     * Message of exception
     * @var string
     */
    protected $message = 'Action is unauthorized';
    /**
     * Exception code
     * @var int
     */
    protected $code = 403;
}