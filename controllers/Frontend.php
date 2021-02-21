<?php


namespace app\controllers;


use app\database\Database;

class Frontend {

    static public function index($router){
        $animals =  $router->db
            ->select('animals')
            ->join('media', 'media_id')
            ->fetchAll();
        $router->renderView('/index', ['animals' => $animals]);
    }

//    static public function animals($router){
//        $query = 'SELECT a.id, a.name, a.type, a.breed, a.colour, a.age, a.status, m.filename as image, a.room_id as room_id, a.friend_id, a.owner_id, a.rehoming_id FROM animals a LEFT JOIN media m ON m.id = a.image_id';
//        $fields = $router->db->executeQuery($query);
//        $router->renderView('/index', ['fields' => $fields]);
//    }


}
