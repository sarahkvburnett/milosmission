<?php


namespace app\models;

use app\Router;
use app\Validator;

abstract class Base {

    // fields in db

    public ?string $_table;
    public ?string $_name;

    public function __construct($data = null) {
        if (!isset($data)) return;
        $fields = $this->getFields();
        foreach($data as $key => $value){
            if (!empty($value) && array_key_exists($key, $fields)){
                $this->$key = $value;
            }
        }
    }

    protected function nameIdField(){
        return $this->_name.'_id';
    }

    protected function getFields(){
        $array = get_object_vars($this);
        foreach($array as $field => $value){
            if(strpos($field, '_') === 0){
                unset($array[$field]);
            }
        }
        return $array;
    }

    public function save($router){
        $fields = $this->getFields();
        $errors = $this->validate($fields);
        if (empty($errors)) {
            $id = $this->nameIdField();
            $router->db->update($this->_table, $fields)->where([$id, $this->$id])->execute();
        }
        return $errors;
    }

    abstract function validate($fields);

}
