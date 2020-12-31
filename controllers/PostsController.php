<?php

namespace app\controllers;

use app\database\Database;
use app\models\Post;
use app\Router;

class PostsController {
    static public function index($router){
        $search = $_GET['search'] ?? '';
        $posts = Database::$db->getPosts($search);
        return $router->renderView('/index', [
            'posts' => $posts,
            'search' => $search
        ]);
    }

    static public function create($router){
        $errors = [];
        $post = [];
        if (isset($_GET['id'])) {
            Database::$db->getPostById($_GET['id']);
        }
        if ($_POST) {
            $post = new Post($_POST);
            $errors = $post->save();
            if(empty($errors)) {
                header("Location: /");
                exit;
            }
        }
        return $router->renderView('/posts/create', [
            'post' => $post,
            'errors' => $errors
        ]);
    }

    static public function delete($router){
        $id = $_POST['id'];
        Database::$db->deletePostById($id);
        header('Location: /');
        exit;
    }

}

