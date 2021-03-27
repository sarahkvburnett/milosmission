<?php


namespace app;


use Exception;

class Request {

    protected static $instance;

    public static function getInstance(){
        if (!isset($instance))  self::$instance = new Request();
        return self::$instance;
    }
    
    public function hasId(){
        if (isset($_GET['id'])) return true;
        if (isset($_POST['id'])) return true;
        return false;
    }

    public function getId(){
        if (isset($_GET['id'])) return $_GET['id'];
        if (isset($_POST['id'])) return $_POST['id'];
        throw new Exception('No ID Parameter', 400);
    }

    public function getSearch(){
        if (isset($_GET['searchColumn']) and isset($_GET['searchValue'])){
           return [$_GET['searchColumn'], $_GET['searchValue']];
        }
        return [];
    }




}
