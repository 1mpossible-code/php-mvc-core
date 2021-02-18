<?php


namespace impossible\phpmvc\middlewares;


use impossible\phpmvc\Application;
use impossible\phpmvc\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 * @package impossible\phpmvc\middlewares
 */
class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];
    /**
     * AuthMiddleware constructor.
     *
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }

}