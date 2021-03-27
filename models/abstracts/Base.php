<?php


namespace app\models\abstracts;

use app\database\Database;

abstract class Base {

    protected ?array $rules;
    protected ?array $types;
    protected ?array $searchables;
    protected ?array $labels;
    protected ?array $columns;
    protected ?array $counts;

    /**
     * Base constructor for view model.
     */
    public function __construct($repo) {
        $this->repo = $repo;
        $this->setLabels();
        $this->setColumns();
        $this->setSearchables();
        $this->setTypes();
        $this->setCounts();
    }

    /**
     * Set validation rules
     */
    abstract function setRules();

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
