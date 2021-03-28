<?php


namespace app\database;


class Connections {

    protected array $connections;

    public function __construct($credentials){
        $this->credentials = $credentials;
    }

    public function add($name, $adaptor){
        $this->connections[$name] = Database::factory($adaptor, $this->credentials[$name]);
    }

    public function get($name){
        return $this->connections[$name];
    }

}
