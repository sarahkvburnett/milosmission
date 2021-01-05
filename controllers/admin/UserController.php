<?php


namespace app\controllers\admin;


use app\database\Database;
use app\models\User;

class UserController {
    static public $urls = [
        'browse' => '/admin/users',
        'details' => '/admin/users/details',
        'delete' => '/admin/users/delete'
    ];

    static public function browse($router){
        $searchColumn = $_GET['searchColumn'] ?? '';
        $searchItem = $_GET['searchItem'] ?? '';
        $search = [
            'column' => $searchColumn,
            'item' => $searchItem
        ];
        $fields = Database::$db->findAll('users', $search);
        return $router->renderView('/admin/browse', [
            'fields' => $fields,
            'title' => 'Users',
            'searchables' => User::$search,
            'actions' => self::$urls,
            'search' => $search
        ]);
    }

    static public function save($router){
        $errors = [];
        $fields = [];
        if (isset($_GET['id'])) {
            $fields = Database::$db->findOneById('users', $_GET['id']);
        } else {
            $data = Database::$db->describe('users');
            foreach ($data as $item){
                $fields[$item['Field']] = '';
            }
        }
        if ($_POST) {
            $user = new User($_POST);
            $errors = $user->save();
            if(empty($errors)) {
                header("Location: /admin/users");
                exit;
            }
        }
        return $router->renderView('/admin/details', [
            'fields' => $fields,
            'errors' => $errors,
            'title' => 'User',
            'actions' => self::$urls,
            'inputs' => User::$inputs,
        ]);
    }

    static public function delete($router){
        $id = $_POST['id'];
        Database::$db->deleteOneById('users', $id);
        header('Location: /admin/users');
        exit;
    }
}
