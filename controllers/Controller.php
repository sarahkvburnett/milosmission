<?php


namespace app\controllers;


use app\database\Database;

class Controller {

    static public function index($router){
        $fields = $router->db->findAll('animals');
        $animals = [];
        foreach( $fields as $field){
            $image = $router->db->findOneById('media', $field['image']);
            $field["image"] = $image['filename'];
            $animals[] = $field;
        };
        $router->renderView('/index', ['animals' => $animals]);
    }

    static public function admin($router){
        $router->renderView('/admin/index');
    }

}
