<?php


namespace app\core\exception;


/**
 * Class ForbiddenException
 * @package app\core\exception
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