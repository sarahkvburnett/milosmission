<?php


namespace app\models\viewmodels\abstracts;

use app\database\Database;

abstract class Admin {

    protected Database $_db;
    protected ?array $types;
    protected ?array $searchables;
    protected ?array $labels;
    protected ?array $columns;

    /**
     * Admin constructor for view model.
     * @param Router $router
     */
    public function __construct($router) {
        $this->_db = $router->db;
        $this->setLabels();
        $this->setColumns();
        $this->setSearchables();
        $this->setTypes();
    }

    /**
     * Set labels for the view form elements
     */
    abstract function setLabels();

    /**
     * Set required columns for the view table (in order)
     */
    abstract function setColumns();

    /**
     * Set types for the view form elements
     */
    abstract function setTypes();

    /**
     * Set the fields to be searchable in search form
     */
    abstract function setSearchables();

    /**
     * Extract view model data for request
     * @return array
     */
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
