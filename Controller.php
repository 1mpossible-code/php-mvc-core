<?php


namespace impossible\phpmvc;

use impossible\phpmvc\middlewares\BaseMiddleware;

/**
 * Class: Controller
 * @package app/core
 *
 */
class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     * @var BaseMiddleware[]
     */
    public array $middlewares = [];

    /**
     * @return BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
