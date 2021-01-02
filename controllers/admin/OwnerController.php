<?php


namespace app\controllers\admin;


use app\database\Database;
use app\models\Owner;

class OwnerController {
    static public $urls = [
        'browse' => '/admin/owners',
        'details' => '/admin/owners/details',
        'delete' => 'admin/owners/delete'
    ];

    static public function browse($router){
        $searchColumn = $_GET['searchColumn'] ?? '';
        $searchItem = $_GET['searchItem'] ?? '';
        $search = [
            'column' => $searchColumn,
            'item' => $searchItem
        ];
        $fields = Database::$db->findAll('owners', $search);
        return $router->renderView('/admin/browse', [
            'fields' => $fields,
            'title' => 'Owners',
            'searchables' => Owner::$search,
            'actions' => Self::$urls,
            'search' => $search,
        ]);
    }

    static public function save($router){
        $errors = [];
        $fields = [];
        $id = $_GET['id'] ?? 1;
        $fields = Database::$db->findOneById('owners', $id);
        if (!isset($_GET['id'])) {
            foreach($fields as $key => $value){
                $fields[$key] = null;
            }
        }
        if ($_POST) {
            $owner = new Owner($_POST);
            $errors = $owner->save();
            if(empty($errors)) {
                header("Location: /admin/owners");
                exit;
            }
        }
        return $router->renderView('/admin/details', [
            'fields' => $fields,
            'errors' => $errors,
            'title' => 'Owner',
            'actions' => Self::$urls,
            'inputs' => Owner::$inputs,
            'options' => Owner::$options
        ]);
    }

    static public function delete($router){
        $id = $_POST['id'];
        Database::$db->deleteOneById('owners', $id);
        header('Location: /admin/owners');
        exit;
    }
}
