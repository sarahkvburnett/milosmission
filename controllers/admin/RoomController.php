<?php


namespace app\controllers\admin;


use app\database\Database;
use app\models\Room;
use app\Validator;

class RoomController {
    static public $urls = [
        'browse' => '/admin/rooms',
        'details' => '/admin/rooms/details',
        'delete' => '/admin/rooms/delete'
    ];

    static public function browse($router){
        $searchColumn = $_GET['searchColumn'] ?? '';
        $searchItem = $_GET['searchItem'] ?? '';
        $search = [
            'column' => $searchColumn,
            'item' => $searchItem
        ];
        $fields = Database::$db->findAll('rooms', $search);
        return $router->renderView('/admin/browse', [
            'fields' => $fields,
            'title' => 'Rooms',
            'name' => 'Room',
            'searchables' => Room::$search,
            'actions' => self::$urls,
            'search' => $search,
        ]);
    }

    static public function save($router){
        $errors = [];
        $fields = [];
        if (isset($_GET['id'])) {
            $fields = Database::$db->findOneById('rooms', $_GET['id']);
        } else {
            $data = Database::$db->describe('rooms');
            foreach ($data as $item){
                $fields[$item['Field']] = '';
            }
        }
        if ($_POST) {
            $array = Validator::sanitiseAll($_POST);
            $rooms = new Room($array);
            $errors = $rooms->save();
            if(empty($errors)) {
                header("Location: /admin/rooms");
                exit;
            }
        }
        return $router->renderView('/admin/details', [
            'fields' => $fields,
            'errors' => $errors,
            'title' => 'Room',
            'actions' => self::$urls,
            'inputs' => Room::$inputs,
            'options' => Room::options(),
        ]);
    }

    static public function delete($router){
        $id = $_POST['id'];
        Database::$db->deleteOneById('rooms', $id);
        header('Location: /admin/rooms');
        exit;
    }
}
