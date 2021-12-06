<?php

namespace app\classes;

use app\classes\Middleware;
use app\classes\Page;
use app\classes\Request;
use app\database\Connections;
use app\repository\abstracts\Repo;
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
        $route = new Route($this->route);
        $page = Page::getInstance();
        $page->dispatch($route);
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
        $repo = Repository::factory('RouterRepo');
        $route = $repo->findRoute($uri);
        //todo check the method against db
        //todo api
        $this->uri = $uri;
        $this->method = $method;
        $this->route = $route;
        if (empty($route)) {
            throw new Exception('Route Not Found', 404);
        }
    }

}
