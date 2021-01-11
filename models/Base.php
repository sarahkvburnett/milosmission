<?php


namespace app\models;


use app\Validator;

abstract class Base {
    public ?string $_table;
    public ?array $_detailsTypes;
    public ?array $_searchFields;
    public ?array $_optionsArray;

    public function __construct($data = null) {
        if (!isset($data)) return;
        foreach($data as $key => $value){
            if ($value === 'N/A') {
                $this->$key = null;
            }
            elseif (!empty($value)){
                $this->$key = $value;
            } else {
                $this->$key = null;
            }
        }
    }

    abstract function getAllOptions($db);

    public function getOptions($db, $table, $column, $where = null){
        $options = ['N/A'];
        $data = $db->findOptions($table, $column, $where);
        if (empty($data)) return $options;
        foreach($data as $row){
            $options[] = $row[$column];
        };
        return $options;
    }

    protected function getFields(){
        $array = get_object_vars($this);
        foreach($array as $field => $value){
            if(strpos($field, '_') === 0){
                unset($array[$field])
;            }
        }
        return $array;
    }

    public function save($db){
        $fields = $this->getFields();
        $errors = $this->validate($fields);
        if (empty($errors)){
            $db->save($this->_table, $fields);
        }
        return $errors;
    }

    abstract function validate($fields);

}
