<?php


namespace app\core\middlewares;


/**
 * Base Middleware class
 * @package app\core\middlewares
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