<?php


namespace app\controllers;


class Admin {

    static public function admin($router){
        $router->renderView('/admin/index');
    }

}
