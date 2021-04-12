<?php

namespace app\classes;

use app\classes\Middleware;
use app\classes\Page;
use app\classes\Request;
use app\database\Connection;
use Error;
use Exception;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class Router {
    public $getRoutes = [];
    public $postRoutes = [];

    private $uri;
    private $method;
    private $route;

    public bool $isAPIRoute;

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
     * Resolve route
     * @param array $route - [string $controller, string $method, array $middleware]
     * @throws Exception
     */
    public function resolve() {
        $page = Page::getInstance();
        $page->dispatch($this->route);
    }

    /**
     * Execute each middleware
     * @param array $mw
     */
    public function executeMiddleware() {
        $request = Request::getInstance();
        //todo auth removed for api
        $route = $this->route;
        if (isset($route[2]) && !$request->isApi()) {
            $mw = $route[2];
            foreach ($mw as $fn) {
                Middleware::$fn();
            }
        }
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
