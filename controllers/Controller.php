<?php


namespace app\controllers;


use app\database\Database;

class Controller {

    static public function index($router){
        $fields = $router->db->findAll('animals');
        $router->renderView('/index', ['fields' => $fields]);
    }

    static public function animals($router){
        $fields = $router->db->findAll('animals');
        $router->renderView('/index', ['fields' => $fields]);
    }


    static public function admin($router){
        $router->renderView('/admin/index');
    }

}
