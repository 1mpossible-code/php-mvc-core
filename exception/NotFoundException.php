<?php


namespace impossible\phpmvc\exception;


class NotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'Not found';

}