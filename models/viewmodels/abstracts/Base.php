<?php


namespace app\models\viewmodels\abstracts;

use app\database\Database;

abstract class Base {

    protected Database $_db;
    protected ?array $types;
    protected ?array $searchables;
    protected ?array $labels;
    protected ?array $columns;

    public function __construct($router) {
        $this->_db = $router->db;
        $this->setLabels();
        $this->setColumns();
        $this->setOptions();
        $this->setSearchables();
        $this->setTypes();
    }

    abstract function setLabels();
    abstract function setColumns();
    abstract function setTypes();
    abstract function setSearchables();

    public function getData(){
        $array = get_object_vars($this);
        foreach($array as $field => $value){
            if(strpos($field, '_') === 0){
                unset($array[$field])
                    ;
            }
        }
        return $array;
    }

}
