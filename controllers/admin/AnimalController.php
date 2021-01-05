<?php


namespace app\controllers\admin;

use app\database\Database;
use app\models\Animal;
use app\Validator;

class AnimalController {
    static public $urls = [
        'browse' => '/admin/animals',
        'details' => '/admin/animals/details',
        'delete' => '/admin/animals/delete'
    ];

    static public function browse($router){
        $searchColumn = $_GET['searchColumn'] ?? '';
        $searchItem = $_GET['searchItem'] ?? '';
        $search = [
            'column' => $searchColumn,
            'item' => $searchItem
        ];
        $fields = Database::$db->findAll('animals', $search);
        $animals = [];
        foreach( $fields as $field){
           $image = Database::$db->findOneById('media', $field['image']);
           $field["image"] = $image['filename'];
           $animals[] = $field;
        };
        return $router->renderView('/admin/browse', [
            'fields' => $animals,
            'title' => 'Animals',
            'searchables' => Animal::$search,
            'actions' => self::$urls,
            'search' => $search,
        ]);
    }

    static public function save($router){
        $errors = [];
        $fields = [];
        $id = $_GET['id'] ?? 1;
        $fields = Database::$db->findOneById('animals', $id);
        if (!isset($_GET['id'])) {
            foreach($fields as $key => $value){
                $fields[$key] = null;
            }
        }
        if ($_POST) {
            $array = Validator::sanitiseAll($_POST);
            $array['room_id'] = Validator::convertStrToInt( $array['room_id']);
            $array['friend_id'] = Validator::convertStrToInt( $array['friend_id']);
            $array['owner_id'] = Validator::convertStrToInt( $array['owner_id']);
            $array['rehoming_id'] = Validator::convertStrToInt( $array['rehoming_id']);
            unset($array['friend_name']);
            //TODO: need to update other changed tables
            $animal = new Animal($array);
            $errors = $animal->save();
            if(empty($errors)) {
                header("Location: /admin/animals");
                exit;
            }
        }
        return $router->renderView('/admin/details', [
            'fields' => $fields,
            'errors' => $errors,
            'title' => 'Animal',
            'actions' => self::$urls,
            'inputs' => Animal::$inputs,
            'options' => Animal::options(),
        ]);
    }

    static public function delete($router){
        $id = $_POST['id'];
        Database::$db->deleteOneById('animals', $id);
        header('Location: /admin/animals');
        exit;
    }
}
