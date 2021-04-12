<?php


namespace app\database;


use app\classes\Database;

class Connection {

    protected $connections;
    protected $credentials;

    public static $instance;

    public static function getInstance(){
        if (!isset(self::$instance)) self::$instance = new Connection();
        return self::$instance;
    }

    public function init($credentials){
        $this->credentials = $credentials;
        return self::$instance;
    }

    public function add($name, $adaptor){
        $this->connections[$name] = Database::factory($adaptor, $this->credentials[$name]);
        return self::$instance;
    }

    public function get($name){
        return $this->connections[$name];
    }

}
