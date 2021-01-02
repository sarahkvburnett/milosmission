<?php


namespace app\controllers;


use app\database\Database;

class Controller {

    static public function index($router){
        $animals = Database::$db->findAll('animals');
        $router->renderView('/index', ['animals' => $animals]);
    }

    static public function admin($router){
        $router->renderView('/admin/index');
    }

}
