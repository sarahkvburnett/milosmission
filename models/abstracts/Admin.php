<?php


namespace app\models\abstracts;

use app\database\Database;
use app\Router;
use app\Validator;

abstract class Admin {

    // fields in db

    public ?string $_table;
    public ?string $_name;

    /**
     * Base constructor.
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
     * Save record in db
     * @param Router $router
     */
    public function save($repo){
        $fields = $this->getFields();
        $idColumn = $this->getIdentifier();
        if(isset($this->$idColumn)){
            $repo->update($this->$idColumn);
        } else {
            $repo->insert($fields);
        }
    }

    /**
     * Validate model data
     * @return array $errors
     */
    abstract function validate();

    /**
     * @return string - name of id column in db
     */
    protected function getIdentifier(){
        return strtolower($this->_name.'_id');
    }

    /**
     * Get db columns from model
     * @return array
     */
    public function getFields(){
        $array = get_object_vars($this);
        foreach($array as $field => $value){
            if(strpos($field, '_') === 0){
                unset($array[$field]);
            }
        }
        return $array;
    }

}
