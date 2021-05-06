<?php


namespace app\core;


use app\core\exception\NotFoundException;

/**
 * Class Router
 * @package app
 */
class Router
{
    /**
     * @var Request
     */
    public Request $request;
    /**
     * @var Response
     */
    public Response $response;
    /**
     * @var array
     */
    protected array $routes = [];

    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        // Define the request
        $this->request = $request;
        // Define the response
        $this->response = $response;
    }

    /**
     * Define route with 'get' method
     * @param $path
     * @param $callback
     */
    public function get($path, $callback): void
    {
        // Add specified callback with specified path
        // to associative array into 'get' routes list
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Define route with 'post' method
     * @param $path
     * @param $callback
     */
    public function post($path, $callback): void
    {
        // Add specified callback with specified path
        // to associative array into 'post' routes list
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Do actions depending on the request
     * @throws NotFoundException
     */
    public function resolve()
    {
        // Get requested path
        $path = $this->request->getPath();
        // Get requested method
        $method = $this->request->method();
        // Get callback from routes with the specified method and path
        $callback = $this->routes[$method][$path] ?? false;
        // If callback is not defined throw Not Found exception
        if ($callback === false) {
            // Throw exception
            throw new NotFoundException();
        }
        // Check if the callback is string; if true render a view
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        // Check if the callback is array; if true replace
        // the link to the controller by its instance in
        // callback array and set Application controller param
        if (is_array($callback)) {
            // Create an instance of controller
            /** @var Controller $controller */
            $controller = new $callback[0]();
            // Set Application controller parameter
            Application::$app->controller = $controller;
            // Set current action to controller
            $controller->action = $callback[1];
            // Replace link by its instance
            $callback[0] = $controller;
            // Iterate over middlewares and execute each one
            foreach ($controller->getMiddlewares() as $middleware) {
                // Execute middleware
                $middleware->execute();
            }
        }
        // Return the result of callback
        return $callback($this->request, $this->response);
    }
}