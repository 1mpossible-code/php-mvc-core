<?php


namespace app\core\exception;


/**
 * Class ForbiddenException
 * @package app\core\exception
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