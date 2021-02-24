<?php


namespace app\models\abstracts;

use app\Router;
use app\Validator;

abstract class Admin {

    // fields in db

    public ?string $_table;
    public ?string $_name;

    /**
     * Admin constructor.
     * @param array $data
     */
    public function __construct($data = []) {
        $this->setName();
        $this->setTable();
        $fields = $this->getFields();
        foreach($data as $key => $value){
            if (!empty($value) && array_key_exists($key, $fields)){
                $this->$key = $value;
            }
        }
    }

    abstract function setTable();
    abstract function setName();

    /**
     * @return string - name of id column in db
     */
    protected function nameIdField(){
        return strtolower($this->_name.'_id');
    }

    /**
     * Get db fields from model
     * @return array
     */
    protected function getFields(){
        $array = get_object_vars($this);
        foreach($array as $field => $value){
            if(strpos($field, '_') === 0){
                unset($array[$field]);
            }
        }
        return $array;
    }

    /**
     * Save record in db
     * @param Router $router
     * @return string lastInsertId
     */
    public function save($router){
        $fields = $this->getFields();
        $idColumn = $this->nameIdField();
        if(isset($this->$idColumn)){
            $router->db->update($this->_table, $fields)->where([$idColumn, $this->$idColumn])->execute();
        } else {
            $router->db->insert($this->_table, $fields)->execute();
        }
        return $router->db->lastInsertId();
    }

    /**
     * Validate model data
     * @return array $errors
     */
    abstract function validate();

}
