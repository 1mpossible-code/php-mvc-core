<?php


namespace app\core;


use app\core\middlewares\Middleware;

/**
 * Base Controller Class
 * @package app\core
 */
class Controller
{
    /**
     * Layout variable
     * @var string
     */
    public string $layout = 'main';
    /**
     * Array that contains middlewares
     * @var Middleware[]
     */
    protected array $middlewares = [];
    /**
     * Current action
     * @var string
     */
    public string $action = '';

    /**
     * Render specified view with specified params if available
     * @param string $view
     * @param array $params
     * @return array|false|string|string[]
     */
    public function render(string $view, array $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    /**
     * Changes the current layout to specified
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * Register new middleware
     * @param Middleware $middleware
     */
    public function registerMiddleware(Middleware $middleware): void
    {
        // Add middleware to middlewares array
        $this->middlewares[] = $middleware;
    }

    /**
     * Get middlewares
     * @return Middleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}