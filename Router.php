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
            $this->renderView("/404", ['errors' => [
                'code' => 404,
                'message' => 'Page Not Found'
            ]], 404);
        }
    }

    public function renderView($view, $data = [], $status = 200){
//        foreach ($params as $key => $value){
//            $$key = $value;
//        }
//        ob_start();
//        include_once __DIR__."/views/$view.php";
//        $content = ob_get_clean();
//        if (str_contains($view, "admin") and !str_contains($view, "login")) {
//            include_once __DIR__."/views/admin/_layout.php";
//        } else {
//            include_once __DIR__."/views/_layout.php";
//        }
        if (isset($data['errors'])){
            $status = 400;
        }
        header('Content-type: application/json', true, $status);
        echo json_encode($data);
        exit;
    }


    public function redirect($url, $data, $status = 200){
//        header("Location: ".$url);
//        exit;
        if (isset($data['errors'])){
            $status = 400;
        }
        header('Content-type: application/json', true, $status);
        echo json_encode($data);
        exit;
    }
}
