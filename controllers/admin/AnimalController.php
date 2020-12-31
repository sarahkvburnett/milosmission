<?php


namespace app\controllers\admin;

use app\database\Database;
use app\models\Animal;

class AnimalController {
    static public function browse($router){
        $searchColumn = $_GET['searchColumn'] ?? '';
        $searchItem = $_GET['searchItem'] ?? '';
        $search = [
            'column' => $searchColumn,
            'item' => $searchItem
        ];
        $fields = Database::$db->getAnimals($search);
        return $router->renderView('/admin/browse', [
            'fields' => $fields,
            'title' => 'Animals',
            'searchables' => Animal::$search,
            'actions' => [
                'get' =>'/admin/animals',
                'create' =>'/admin/animals/details',
            ],
            'search' => $search,
        ]);
    }

    static public function save($router){
        $errors = [];
        $fields = [];
        $id = $_GET['id'] ?? 1;
        $fields = Database::$db->getAnimalById($id);
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
            'titles' => [
                'create' => 'Create new animal',
                'update' => 'Update animal',
            ],
            'actions' => [
                'save' =>'/admin/animals/details',
                'delete' =>'/admin/animals/delete',
                'browse' =>'/admin/animals'
            ],
            'inputs' => Animal::$inputs,
            'options' => Animal::$options
        ]);
    }

    static public function delete($router){
        $id = $_POST['id'];
        Database::$db->deleteAnimalById($id);
        header('Location: /admin/animals');
        exit;
    }
}
