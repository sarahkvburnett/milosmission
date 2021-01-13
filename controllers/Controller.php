<?php


namespace app\controllers;


use app\database\Database;

class Controller {

    static public function index($router){
        $query = 'SELECT a.id, a.name, a.type, a.breed, a.colour, a.age, a.status, m.filename as image, a.room_id as room_id, a.friend_id, a.owner_id, a.rehoming_id FROM animals a LEFT JOIN media m ON m.id = a.image_id';
        $animals = $router->db->executeQuery($query);
        $router->renderView('/index', ['animals' => $animals]);
    }

    static public function admin($router){
        $router->renderView('/admin/index');
    }

}
