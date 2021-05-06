<?php


namespace impossible\phpmvc\exception;


/**
 * Class ForbiddenException
 * @package impossible\phpmvc\exception
 */
class NotFoundException extends \Exception
{
    /**
     * Message of exception
     * @var string
     */
    protected $message = 'Not found';
    /**
     * Exception code
     * @var int
     */
    protected $code = 404;
}