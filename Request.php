<?php


namespace app\core;


/**
 * Class Request
 * @package app\core
 */
class Request
{
    /**
     * Return a URI path without additional parameters
     * ( return '/test' from 'domain.com/test?foo=bar' )
     * @return false|mixed|string
     */
    public function getPath()
    {
        // Get URI with parameters
        $path = $_SERVER['REQUEST_URI'];
        // Get position of '?'
        $position = strpos($path, '?');
        // If position not found, return thw whole URI
        if ($position === false) {
            return $path;
        }
        // Return the URI without additional parameters
        return substr($path, 0, $position);
    }

    /**
     * Return method of the request
     * @return string
     */
    public function method(): string
    {
        // Return requested method in lower case
        return strtolower( $_SERVER['REQUEST_METHOD'] );
    }

    /**
     * Get clear data from 'get' or 'post' request
     * @return array
     */
    public function getBody(): array
    {
        $body = [];
        // Sanitize 'get' data and save each key to $body variable
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        // Sanitize 'post' data and save each key to $body variable
        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        // Return sanitized data
        return $body;
    }
}