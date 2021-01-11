<?php

namespace app;

use app\Middleware;

class Router {
    public $getRoutes = [];
    public $postRoutes = [];

    public $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function executeMiddleware($mw = []){
        foreach($mw as $fn){
            Middleware::$fn();
        }
    }

    public function get($url, $fn, $mw = []){
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn, $mw = []){
        $this->postRoutes[$url] = $fn;
    }

    public function renderView($view, $params = []){
        foreach ($params as $key => $value){
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

    public function resolve(){
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = strtok($uri, '?');
        if ($method === 'get') {
            $fn = $this->getRoutes[$uri] ?? null;
        } else {
            $fn = $this->postRoutes[$uri] ?? null;
        };
        if ($fn) {
            if (isset($fn[2])) {
                $this->executeMiddleware($fn[2]);
                unset($fn[2]);
            }
            $fn($this);
        } else {
            $this->renderView("/404");
        }
    }

    public function redirect($url){
        header("Location: ".$url);
        exit;
    }
}
