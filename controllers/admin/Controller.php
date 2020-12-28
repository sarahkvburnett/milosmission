<?php


namespace app\controllers\admin;


class Controller {
    static public function index($router){
        $router->renderView('/admin/index');
    }
}