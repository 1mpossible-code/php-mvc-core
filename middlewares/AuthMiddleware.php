<?php


namespace impossible\phpmvc\middlewares;


use impossible\phpmvc\Application;
use impossible\phpmvc\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 * @package impossible\phpmvc\middlewares
 */
class AuthMiddleware extends Middleware
{
    /**
     * Actions that should be
     * restricted by this middleware
     * @var array
     */
    public array $actions = [];

    /**
     * AuthMiddleware constructor.
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        // Set actions
        $this->actions = $actions;
    }

    /**
     * @return void
     * @throws ForbiddenException
     */
    public function execute(): void
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions, true)) {
                throw new ForbiddenException();
            }
        }
    }
}