<?php

namespace app;

use app\database\Database;
use app\Middleware;
use app\repository\OptionsRepo;
use Error;
use Exception;

class Router {
    public $getRoutes = [];
    public $postRoutes = [];

    private $uri;
    private $method;
    private $route;

    public bool $isAPIRoute;

    protected $dbConnections;

    public function __construct($dbConnections){
        $this->dbConnections = $dbConnections;
    }

    /**
     * Add get route to routes with route information [name of controller, method to call, middleware]
     * @param string $url
     * @param array $route - [string $controller, string $method, array $middleware]
     */
    public function get($url, $route) {
        $this->getRoutes[$url] = $route;
    }

    /**
     * Add post route to routes with route information [name of controller, method to call, middleware]
     * @param string $url
     * @param array $route - [string $controller, string $method, array $middleware]
     */
    public function post($url, $route) {
        $this->postRoutes[$url] = $route;
    }

    /**
     * Resolve route by instantiating controller and calling method
     * @param array $route - [string $controller, string $method, array $middleware]
     * @throws Exception
     */
    public function resolve() {
        [$controller, $method] = $this->route;
        $class = $this->findController($controller);
        $repo = $this->findRepo($controller);
        $controller = new $class(new $repo($this->dbConnections));
        $controller->$method($this);
    }

    /**
     * Handle sending of response - json vs view
     * @param $url
     * @param array $data
     * @param int $status
     * @throws Exception
     */
    public function sendResponse($url, $data = [], $status = 200){
        $currentURL = $this->uri ? $this->uri : $url;
        if ($this->isAPIRoute) {
            $this->sendJSON($data, $status);
        } else {
            if (empty($url)) throw new Exception('Template not specified');
            $this->renderView($url, $data, $status);
        }
    }

    /**
     * @param string $view
     * @param array $data
     * @param int $status
     */
    public function renderView($view, $data = [], $status = 200) {
        foreach ($data as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once __DIR__."/views/$view.php";
        $content = ob_get_clean();
        if (str_contains($view, "admin") and !str_contains($view, "login")) {
            include_once __DIR__."/views/admin/_layout.php";
        } else {
            include_once __DIR__."/views/_layout.php";
        }
    }

    /**
     * Redirect
     * @param string $url
     */
    public function redirect($url) {
        if ($this->isAPIRoute) {
            $this->sendJSON([], 302);
        } else {
            header("Location: " . $url);
            exit;
        }
    }

    /**
     * Send response as JSON
     * @param array $data
     * @param int $status
     */
    public function sendJSON($data, $status = 200) {
        header('Content-type: application/json', true, $status);
        echo json_encode($data);
        exit;
    }

    /**
     * Execute each middleware
     * @param array $mw
     */
    public function executeMiddleware() {
        //todo auth removed for api
        $route = $this->route;
        if (isset($route[2]) && !$this->isAPIRoute) {
            $mw = $route[2];
            foreach ($mw as $fn) {
                Middleware::$fn();
            }
        }
    }

    /**
     * Send error response
     * @param Exception $e
     */
    public function handleException($e) {
        $data = ['errors' => [
            'status' => $e->getCode(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]];
        $this->sendResponse('error', $data, $e->getCode());
    }

    /**
     * Find route matching request uri and method
     * @param $uri
     * @param $method
     * @return array $route
     * @throws Exception
     */
    public function findRoute($uri, $method){
        if ($method === 'get') {
            $route = $this->getRoutes[$uri] ?? [];
        } else {
           $route = $this->postRoutes[$uri] ?? [];
        };
        $this->uri = $uri;
        $this->method = $method;
        $this->route = $route;
        $this->setIsAPIRoute($uri);
        if (!$route) {
            throw new Exception('Route Not Found', 404);
        }
    }

    /**
     * Find controller class
     * @param $class
     * @return string
     * @throws Exception
     */
    protected function findController($class){
        $sources = ['app\controllers\\', 'app\controllers\admin\\'];
        foreach ($sources as $source){
            if (class_exists($source.$class)){
                return $source.$class;
            }
        }
        throw new Exception('Controller Not Found', 404);
    }

    /**
     * Find repository class
     * @param $class
     * @return string
     */
    protected function findRepo($class){
        return 'app\repository\\'.$class.'Repo';
    }

    /**
     * @param string $uri
     */
    private function setIsAPIRoute($uri) {
        $this->isAPIRoute = str_contains($uri, 'api');
    }
}
