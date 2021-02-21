<?php

namespace app;

use app\database\Database;
use app\Middleware;
use Error;
use Exception;

class Router {
    public $getRoutes = [];
    public $postRoutes = [];

    public $db;

    /**
     * Router constructor.
     * @param Database $db
     */
    public function __construct($db) {
        $this->db = $db;
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
    public function resolve($route) {
        [$controller, $method] = $route;
        $class = $this->findClass($controller);
        $controller = new $class($this);
        $controller->$method($this);
    }

    /**
     * Send view in response
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
//        $this->sendJSON($data, $status);
    }


    /**
     * Redirect
     * @param string $url
     */
    public function redirect($url) {
        header("Location: ".$url);
        exit;
//        $this->sendJSON();
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
    public function executeMiddleware($route) {
        if (isset($route[2])) {
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
        $this->renderView('error', $data, $e->getCode());
    }

    /**
     * Get request method from request
     * @param $request
     * @return string
     */
    public function getMethod($request){
        return strtolower($request['REQUEST_METHOD']);
    }

    /**
     * Get request uri from request
     * @param $request
     * @return string
     */
    public function getUri($request){
        $uri = $request['REQUEST_URI'] ?? '/';
        return strtok($uri, '?');
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
        if (!$route) throw new Exception('Route Not Found', 404);
        return $route;
    }

    /**
     * Find controller class
     * @param $class
     * @return string
     * @throws Exception
     */
    protected function findClass($class){
        $sources = ['app\controllers\\', 'app\controllers\admin\\'];
        foreach ($sources as $source){
            if (class_exists($source.$class)){
                return $source.$class;
            }
        }
        throw new Exception('Controller Not Found', 404);
    }
}
