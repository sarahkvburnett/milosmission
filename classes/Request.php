<?php


namespace app\classes;


use Exception;

class Request {

    protected static $instance;

    public static function getInstance(){
        if (!isset($instance))  self::$instance = new Request();
        return self::$instance;
    }

    public function has($param){
        if (isset($_GET[$param])) return true;
        if (isset($_POST[$param])) return true;
        return false;
    }

    public function get($param){
        if (isset($_GET[$param])) return $_GET[$param];
        if (isset($_POST[$param])) return $_POST[$param];
        return false;
    }

    public function hasId(){
        return $this->has('id');
    }

    public function getId(){
        $id = $this->get('id');
        if ($id) return $id;
        throw new Exception('No ID Parameter', 400);
    }

    public function getSearch(){
        if (isset($_GET['searchColumn']) and isset($_GET['searchValue'])){
           return [$_GET['searchColumn'], $_GET['searchValue']];
        }
        return [];
    }

    public function isApi(){
        return str_contains($_SERVER['REQUEST_URI'], '/api/');
    }

    public function isAdmin(){
        return str_contains($_SERVER['REQUEST_URI'], '/admin/');
    }

    public function hasPost(){
        if ($this->isAPI()) $_POST = json_decode(file_get_contents('php://input'), true);
        return !empty($_POST);
    }

    public function getPost(){
        if ($this->isAPI()) $_POST = json_decode(file_get_contents('php://input'), true);
        return $_POST;
    }

    public function hasFiles(){
        return !empty($_FILES);
    }

    public function getFiles(){
        return $_FILES;
    }


}
