<?php


namespace app\core;


use app\models\User;
use Exception;

/**
 * Main class of application
 * @package app
 */
class Application
{
    /**
     * @var string
     */
    public static string $ROOT_DIR;
    /**
     * @var string
     */
    public string $userClass;
    /**
     * @var Router
     */
    public Router $router;
    /**
     * @var Request
     */
    public Request $request;
    /**
     * @var Response
     */
    public Response $response;
    /**
     * @var Session
     */
    public Session $session;
    /**
     * @var Controller
     */
    public Controller $controller;
    /**
     * @var View
     */
    public View $view;
    /**
     * Default layout
     * @var string
     */
    public string $layout;
    /**
     * Static property that is this class
     * @var Application
     */
    public static Application $app;
    /**
     * @var Database
     */
    public Database $db;

    /**
     * @var DbModel|null
     */
    public ?DbModel $user;

    /**
     * Application constructor.
     */
    public function __construct(string $rootPath, array $config)
    {
        // Get user class string from config
        $this->userClass = $config['userClass'] ?? User::class;
        // Get layout from config or 'main'
        // as default value
        $this->layout = $config['layout'] ?? 'main';
        // Root path defining
        self::$ROOT_DIR = $rootPath;
        // Define this as a static property
        self::$app = $this;
        // Create instances
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        // Create database connection
        $this->db = new Database($config['db']);
        // Set user
        $this->user = $this->getUser();
    }

    /**
     * Main function of application that starts it
     */
    public function run(): void
    {
        // If have exceptions handle them
        try {
            // Router start resolving
            echo $this->router->resolve();
        } catch (Exception $exception) {
            // Set exception status code
            $this->response->setStatusCode($exception->getCode());
            // Render _error view with exception
            echo Application::$app->view->renderView('_error', [
                'exception' => $exception,
            ]);
        }
    }

    /**
     * Login user into application,
     * save it to session
     * @param DbModel $user
     * @return bool
     */
    public function login(DbModel $user): bool
    {
        // Save user to application
        $this->user = $user;
        // Get user's primary key
        $primaryKey = $user->primaryKey();
        // Get user's value of primary key
        $primaryValue = $user->{$primaryKey};
        // Set session's user value as a primary value
        $this->session->set('user', $primaryValue);
        // If no error return true
        return true;
    }

    /**
     * Logout user and
     * remove him form session
     */
    public function logout(): void
    {
        // Set user application
        // value to null
        $this->user = null;
        // Remove user value from session
        $this->session->remove('user');
    }

    /**
     * Get application
     * user from session
     */
    public function getUser()
    {
        // Get user's primary key
        $primaryValue = $this->session->get('user');
        // Set user is primary value is exists
        if ($primaryValue) {
            // Get user's value of primary key
            $primaryKey = $this->userClass::primaryKey();
            // Get user with primary key and value, then return
            return $this->userClass::findOne([$primaryKey => $primaryValue]);
        }
        // If no primary value return null
        return null;
    }

    /**
     * If current user is guest
     * @return bool
     */
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
}