<?php


namespace app\controllers\admin;

use app\database\Database;
use app\models\Animal;

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
        return $router->renderView('/admin/browse', [
            'fields' => $fields,
            'title' => 'Animals',
            'searchables' => Animal::$search,
            'actions' => Self::$urls,
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
            $animal = new Animal($_POST);
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
            'options' => Animal::$options
        ]);
    }

    static public function delete($router){
        $id = $_POST['id'];
        Database::$db->deleteOneById('animals', $id);
        header('Location: /admin/animals');
        exit;
    }
}
