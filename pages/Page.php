<?php


namespace app\pages;


use Exception;

class Page {

    public static $instance;

    public static function setInstance($page = null){
        if (!isset($instance)) self::$instance = self::factory($page);
        return self::$instance;
    }

    public static function getInstance(){
        return self::$instance;
    }

    protected static function factory($page){
        $sources = ['app\\pages\\page\\', 'app\pages\page\admin\\'];
        foreach ($sources as $source) {
            if (class_exists($source . $page)) {
                $class = $source.$page;
                return new $class;
            }
        }
        throw new Exception('Page Not Found', 404);
    }

}
