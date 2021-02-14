<?php

namespace app;

use app\Middleware;
use Error;
use Exception;

class Router {
    public $getRoutes = [];
    public $postRoutes = [];

    public $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function get($url, $controller) {
        $this->getRoutes[$url] = $controller;
    }

    public function post($url, $controller) {
        $this->postRoutes[$url] = $controller;
    }

    public function resolve($route) {
        [$controller, $method] = $route;
        $class = $this->findClass($controller);
        $controller = new $class($class);
        $controller->$method($this);
    }

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


    public function redirect($url) {
        header("Location: ".$url);
        exit;
//        $this->sendJSON();
    }

    public function sendJSON($data, $status = 200) {
        header('Content-type: application/json', true, $status);
        echo json_encode($data);
        exit;
    }

    public function executeMiddleware($mw = []) {
        foreach ($mw as $fn) {
            Middleware::$fn();
        }
    }

    public function handleError($e) {
        $data = ['errors' => [
            'status' => $e->getCode(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]];
        $this->renderView('error', $data, $e->getCode());
    }

    public function getMethod($request){
        return strtolower($request['REQUEST_METHOD']);
    }

    public function getUri($request){
        $uri = $request['REQUEST_URI'] ?? '/';
        return strtok($uri, '?');
    }

    public function findRoute($uri, $method){
        if ($method === 'get') {
            $route = $this->getRoutes[$uri] ?? [];
        } else {
           $route = $this->postRoutes[$uri] ?? [];
        };
        if ($route){
            return $route;
        } else {
            throw new Exception('Route Not Found', 404);
        }
    }

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
