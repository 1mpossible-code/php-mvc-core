<?php


namespace app\core;


/**
 * Class Response
 * @package app\core
 */
class Response
{
    /**
     * Set specified status code
     * @param int $code
     */
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * Redirect to specified url
     * @param string $url
     */
    public function redirect(string $url): void
    {
        header('Location: ' . $url);
    }
}