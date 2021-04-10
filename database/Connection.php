<?php


namespace app\database;


use app\classes\Database;

class Connection {

    protected array $connections;
    protected array $credentials;

    public static Connection $instance;

    public static function setInstance($credentials){
        if (!isset(self::$instance)) self::$instance = new Connection($credentials);
        return self::$instance;
    }

    public static function getInstance(){
        return self::$instance;
    }

    protected function __construct($credentials){
        $this->credentials = $credentials;
    }

    public function add($name, $adaptor){
        $this->connections[$name] = Database::factory($adaptor, $this->credentials[$name]);
    }

    public function get($name){
        return $this->connections[$name];
    }

}
