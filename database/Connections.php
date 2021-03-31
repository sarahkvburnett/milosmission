<?php


namespace app\database;


class Connections {

    protected array $connections;
    protected array $credentials;

    public static Connections $instance;

    public static function setInstance($credentials){
        if (!isset(self::$instance)) self::$instance = new Connections($credentials);
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
