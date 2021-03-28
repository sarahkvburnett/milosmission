<?php

namespace app\classes;

use app\classes\Middleware;
use app\classes\Page;
use app\database\Connections;
use Error;
use Exception;

class Router {
    public $getRoutes = [];
    public $postRoutes = [];

    private $uri;
    private $method;
    private $route;

    public bool $isAPIRoute;

    protected Connections $dbConnections;

    public function __construct($dbConnections){
        $this->dbConnections = $dbConnections;
        $this->root = dirname(__FILE__).'../../';
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
        [$class, $method] = $this->route;
        $page = Page::setInstance($class);
        $repo = $page->setRepo($this->dbConnections);
        $controller = $page->setController($repo);
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
        $request = Request::getInstance();
        if ($request->isApi()) {
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
       $ROOT = $this->root;
        foreach ($data as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once $ROOT."views/$view.php";
        $content = ob_get_clean();
        if (str_contains($view, "admin") and !str_contains($view, "login")) {
            include_once $ROOT."views/admin/_layout.php";
        } else {
            include_once $ROOT."views/_layout.php";
        }
    }

    /**
     * Redirect
     * @param string $url
     */
    public function redirect($url) {
        $request = Request::getInstance();
        if ($request->isApi()) {
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
        $request = Request::getInstance();
        //todo auth removed for api - cookie
        $route = $this->route;
        if (isset($route[2]) && !$request->isApi()) {
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
        $route = $method === 'get' ? $this->getRoutes[$uri] ?? [] : $this->postRoutes[$uri] ?? [];
        $this->uri = $uri;
        $this->method = $method;
        $this->route = $route;
        if (!$route) {
            throw new Exception('Route Not Found', 404);
        }
    }

}
