<?php


namespace impossible\phpmvc\middlewares;


/**
 * Base Middleware class
 * @package impossible\phpmvc\middlewares
 */
abstract class Middleware
{
    /**
     * Method that executes
     * the middleware process
     * @return mixed
     */
    abstract public function execute();
}