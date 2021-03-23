<?php


namespace app\controllers;


use app\database\Database;

class Frontend {

    static public function index($router){
        $db = Database::getInstance();
        $animals = $db->select('animals')->join('media', 'media_id')->fetchAll();
        $router->renderView('/index', ['animals' => $animals]);
    }

}
